<h2 class="text-success text-center mt-4">Contactos</h2>
<ul class="list-group">
    <?php
    $contactos = ["611-11-11-11", "correo@ejemplo.net", "Calle inventada n7, Camas, Sevilla", "www.paginaweb.net"];
    foreach ($contactos as $c) {
        echo "<li class='list-group-item'>" . htmlspecialchars($c) . "</li>";
    }
    ?>
</ul>