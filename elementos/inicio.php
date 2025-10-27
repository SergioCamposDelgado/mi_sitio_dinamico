<?php
session_start();
$user = $_SESSION['usuario'];
?>

<h2 class="text-success text-center mt-4">Pagina Web creada con PHP</h2>
<h3 class="text-success text-center mt-4">Hola, <?= $user ?>
</h3>
<h3 class="text-success text-center mt-4">
    <form method='POST' action='procesar_acceso.php'>
        <input type='hidden' name='logout' value='logout'>
        <input type='submit' value='Cerrar sesión'>
    </form>
</h3>