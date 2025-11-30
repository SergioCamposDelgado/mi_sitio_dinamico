<?php
// vistas/producto/lista.php
// Variables disponibles: $auth (array|null), $productos (Producto[])

$rol = $auth['rol'] ?? 'visitante';
$nombre = $auth['nombre'] ?? 'Invitado';
$esManager = ($rol === 'manager');
$esCliente = ($rol === 'usuario');
$cantidadTotal = array_sum($_SESSION['carrito'] ?? []);  // Suma todas las cantidades

var_dump($_SESSION['carrito']);
?>
<h2 class="text-success text-center mt-4">Productos locales de Camas</h2>
<p class="text-center text-muted">Bienvenido, <?= htmlspecialchars($nombre) ?></p>

<?php if ($esManager): ?>
  <div class="text-center mb-3">
    <a href="index.php?p=productos&action=nuevo" class="btn btn-primary">➕ Añadir producto</a>
  </div>
<?php endif; ?>

<table class="table table-bordered table-striped w-75 mx-auto mt-4 text-center align-middle">
  <thead class="table-primary">
    <tr>
      <th>Producto</th>
      <th>Precio (€)</th>
      <?php if ($esManager): ?>
        <th>Acciones</th>
      <?php endif; ?>
      <?php if ($esCliente): ?>
        <th>Comprar</th>

        <?php if ($cantidadTotal > 0): ?>
          <a href="index.php?p=carrito&action=verCarrito" class="btn btn-success position-relative shadow-sm">
            <i class="bi bi-cart3 me-1"></i>
            Mi carrito 🛒
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              <?= $cantidadTotal ?>
              <span class="visually-hidden">productos en carrito</span>
            </span>
          </a>
        <?php endif; ?>
      <?php endif; ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($productos as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p->nombre) ?></td>
        <td><?= number_format((float)$p->precio, 2, ',', '.') ?></td>

        <?php if ($esManager): ?>
          <td>
            <a href="index.php?p=productos&action=detalle&id=<?= htmlspecialchars((string)$p->getId()) ?>" class="btn btn-sm btn-warning">👁️ Detalle</a>
          </td>
        <?php endif; ?>

        <?php if ($esCliente): ?>
          <td>
            <form action="index.php" method="GET" class="d-inline">
              <input type="hidden" name="p" value="carrito" />
              <input type="hidden" name="action" value="add" /> <!-- más corto -->
              <input type="hidden" name="id" value="<?= $p->getId() ?>" />

              <div class="input-group input-group-sm" style="width: 200px;">
                <input type="number"
                  name="cant"
                  value="1"
                  min="1"
                  max="<?= $p->stock ?>"
                  class="form-control text-center"
                  style="width: 70px;">
                <button type="submit" class="btn btn-success btn-sm">
                  Añadir
                </button>
              </div>
            </form>
          </td>
        <?php endif; ?>
      </tr>
    <?php endforeach; ?>
    <?php if (empty($productos)): ?>
      <tr>
        <td colspan="<?= ($esManager || $esCliente) ? 3 : 2 ?>" class="text-center text-muted">No hay productos aún.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>