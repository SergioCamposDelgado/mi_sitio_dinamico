<?php
  $menu = [
    'inicio' => 'Inicio',
    'contenido' => 'Productos',
    'contacto' => 'Contacto'
  ];
?>

<header class="text-center bg-white p-3 rounded shadow-sm">
  <h1 class="text-primary">🌟 Bienvenido Camas - Mi Sitio Dinámico PHP 🌟</h1>
  <p class="text-muted">Usando include() por primera vez</p>
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Barra de navegación</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <?php foreach ($menu as $clave => $texto): ?>
            <li class="nav-item">
              <a class="nav-link <?= ($p === $clave) ? 'active' : '' ?>"
                href="index.php?p=<?= $clave ?>">
                <?= htmlspecialchars($texto) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>