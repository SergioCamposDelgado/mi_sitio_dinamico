<?php

require_once __DIR__ . '/../../modelo/dao/ProductoDAO.php';
require_once __DIR__ . '/../../nucleo/Database.php';
require_once __DIR__ . '/../../modelo/Producto.php';


function agregarAlCarrito(int $producto_id, int $cantidad = 1): void
{
    // Inicializa el carrito si no existe
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];  // Formato: [id_producto => cantidad]
    }

    if ($cantidad <= 0) {
        unset($_SESSION['carrito'][$producto_id]); // Si es 0 o negativo, lo quitamos
    } else {
        // Si ya existe, sumamos. Si no, creamos.
        $_SESSION['carrito'][$producto_id] =
            ($_SESSION['carrito'][$producto_id] ?? 0) + $cantidad;
    }
}

function validarYActualizarCarrito(): array
{
    // Aseguramos sesión
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    // Si no hay carrito → devolver vacío
    if (empty($_SESSION['carrito'] ?? [])) {
        return ['items' => [], 'total' => 0.0, 'cambios' => false];
    }

    $pdo = Database::getConnection();
    $dao = new ProductoDAO($pdo);

    $itemsValidados = [];
    $total = 0.0;
    $huboCambios = false;

    foreach ($_SESSION['carrito'] as $id => $cantidadSolicitada) {
        $id = (int)$id;
        $cantidadSolicitada = (int)$cantidadSolicitada;

        // Buscar producto actual en BBDD
        $producto = $dao->buscarPorId($id);

        // 1. Si el producto ya no existe → eliminar del carrito
        if (!$producto) {
            unset($_SESSION['carrito'][$id]);
            $huboCambios = true;
            continue;
        }

        // 2. Ajustar al stock real
        $stockReal = (int)$producto->stock;
        $cantidadFinal = $cantidadSolicitada;

        if ($cantidadSolicitada > $stockReal) {
            $cantidadFinal = $stockReal;
            $huboCambios = true;
        }

        // 3. Si no hay stock → eliminar
        if ($cantidadFinal <= 0) {
            unset($_SESSION['carrito'][$id]);
            $huboCambios = true;
            continue;
        }

        // 4. Actualizar sesión si cambió la cantidad
        if ($cantidadFinal !== $cantidadSolicitada) {
            $_SESSION['carrito'][$id] = $cantidadFinal;
        }

        // 5. Calcular con precio real (por si cambió)
        $subtotal = $producto->precio * $cantidadFinal;
        $total += $subtotal;

        $itemsValidados[] = [
            'producto'  => $producto,
            'cantidad'  => $cantidadFinal,
            'subtotal'  => $subtotal
        ];
    }

    return [
        'items'   => $itemsValidados,
        'total'   => $total,
        'cambios' => $huboCambios
    ];
}

function paginaCarrito(): string
{

    $datos = validarYActualizarCarrito();

    if (empty($datos['items'])) {
        $_SESSION['carrito'] = [];
        return '<div class="text-center py-5">
                    <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                    <h3 class="mt-4 text-muted">Tu carrito está vacío</h3>
                    <p class="lead">¡Empieza a añadir productos!</p>
                    <a href="index.php?p=contenido" class="btn btn-primary btn-lg mt-3">
                        <i class="bi bi-shop me-2"></i> Ir a comprar
                    </a>
                </div>';
    }

    

    // Construimos el HTML bonito
    $html = '<div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-cart-check me-2"></i>
                        Tu carrito (' . count($datos['items']) . ' productos)
                    </h4>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cant.</th>
                                    <th class="text-end">Precio</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>';


    foreach ($datos['items'] as $item) {
        $p = $item['producto'];
        $html .= '<tr>
                    <td>
                        <strong>' . htmlspecialchars($p->nombre) . '</strong>
                        <small class="text-muted d-block">' . htmlspecialchars($p->descripcion ?? '') . '</small>
                    </td>
                    <td class="text-center align-middle">
                        <span class="badge bg-primary fs-6">' . $item['cantidad'] . '</span>
                    </td>
                    <td class="text-end align-middle">$ ' . number_format($p->precio, 2) . '</td>
                    <td class="text-end align-middle fw-bold text-success">$ ' . number_format($item['subtotal'], 2) . '</td>
                    <td class="text-end">
                        <a href="index.php?p=carrito&action=eliminar&id=' . $p->getId()  . '" 
                           class="btn btn-sm btn-outline-danger" title="Quitar">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                  </tr>';
    }
    $html .= '          </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-light">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <a href="index.php?p=contenido" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i> Seguir comprando
                            </a>
                            <a href="index.php?p=carrito&action=vaciar" class="btn btn-outline-danger ms-2">
                                <i class="bi bi-cart-x me-2"></i> Vaciar carrito
                            </a>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <h4 class="mb-0">
                                Total: 
                                <span class="text-success fw-bold">$ ' . $datos['total'] . '</span>
                            </h4>
                            <a href="index.php" class="btn btn-success btn-lg mt-3 px-5">
                                <i class="bi bi-credit-card me-2"></i> Ir a pagar
                            </a>
                        </div>
                    </div>
                </div>
             </div>';

    return $html;
}


function vaciarCarrito()
{
    $_SESSION['carrito'] = [];
}

function eliminarProducto(int $id): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];  // Formato: [id_producto => cantidad]
    }

    unset($_SESSION['carrito'][$id]);
}
