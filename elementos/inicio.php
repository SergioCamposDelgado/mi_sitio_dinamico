<?php
include_once('plantillas.php');
session_start();
$user = $_SESSION['usuario'];
?>

<h2 class="text-success text-center mt-4">Pagina Web creada con PHP</h2>
<h3 class="text-success text-center mt-4">Hola, <?= $user ?>
</h3>
<h3 class="text-success text-center mt-4">
    <?= generarLogout()?>
</h3>