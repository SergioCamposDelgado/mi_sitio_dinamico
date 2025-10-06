<h2 class="text-success text-center mt-4">Productos locales de Camas</h2>
<ul class="list-group">
  <?php
  $productos = ["Pan de Camas", "Aceitunas aliñadas", "Tortas de aceite","Manzanas verdes"];
  foreach ($productos as $p) {
    echo "<li class='list-group-item'>" . htmlspecialchars($p) . "</li>";
  }
  ?>
</ul>