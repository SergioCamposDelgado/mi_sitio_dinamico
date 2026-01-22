<?php
<<<<<<< HEAD
$menu = [
    'inicio' => 'elementos/inicio.php',
    'contenido' => 'elementos/contenido.php',
    'contacto' => 'elementos/contacto.php'
];
$p = $_GET['p'] ?? 'inicio';
$contenido;
foreach ($menu as $clave => $texto):
    if ($p === $clave) {
        $contenido = $texto;
    }
endforeach;
$titulo = "Mi primer sitio modular con PHP";
=======
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
>>>>>>> feature/seleccion-compra

require_once __DIR__ . '/config.php';

// Parámetro de vista (?p=)
$p = $_GET['p'] ?? 'inicio';

// Carga la vista principal
include __DIR__ . '/vistas/layout.php';