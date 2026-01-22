<?php
// Variables: $auth (array|null)
// Si $producto está definido, estamos en modo edición
$rol = $auth['rol'] ?? 'visitante';
$esManager = ($rol === 'manager');

$productoEncontrado = isset($producto);

$valNombre = $productoEncontrado ? $producto->nombre : '';
$valPrecio = $productoEncontrado ? (string)$valNombre : '';

$valStock = $productoEncontrado? (string)$producto->stock : '';
$valDescripcion = $productoEncontrado? $producto->descripcion : '';

$valId     = $productoEncontrado ? (int)$producto->getId() : 0;

$titulo = $productoEncontrado ? 'Producto: ' . $valNombre : 'Error, producto no identificado';



?>
<h2 class="text-success text-center mt-4"><?= htmlspecialchars($titulo) ?></h2>

<?php if (!$esManager): ?>
    <div class="alert alert-danger w-75 mx-auto">No tienes permisos para ver el producto.</div>
    <?php return; ?>
<?php endif; ?>

<table class="table table-bordered table-striped w-75 mx-auto mt-4 text-center align-middle">
    <thead class="table-primary">
        <tr>
            <th>Producto</th>
            <th>Precio (€)</th>
            <th>Stock</th>
            <th>Descripcion</th>
            <?php if ($esManager): ?>
                <th>Acciones</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= htmlspecialchars($valNombre) ?></td>
            <td><?= number_format((float)$valPrecio, 2, ',', '.') ?></td>
            <td><?= htmlspecialchars($valStock) ?>
                <?php if ($producto->stock < 15): ?>
                    <span class="badge bg-danger ms-2">Bajo stock</span>
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($valDescripcion) ?></td>

            <?php if ($esManager): ?>
                <td>
                    <a href="index.php?p=productos&action=editar&id=<?= htmlspecialchars((string)$valId)  ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                    <!-- Eliminar SIEMPRE por POST, no GET -->
                    <form method="post" action="index.php?p=productos&action=eliminar" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string)$valId) ?>">
                        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf'] ?? '') ?>">
                        <button class="btn btn-sm btn-danger" type="submit">🗑️ Eliminar</button>
                    </form>
                </td>
            <?php endif; ?>
        </tr>
        <?php if (!$productoEncontrado) : ?>
            <tr>
                <td colspan="<?= $esManager ? 6 : 5 ?>" class="text-center text-muted">Producto no cargado</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="d-flex gap-2">
    <a class="btn btn-secondary" href="index.php?p=contenido">Volver</a>
</div>
</form>