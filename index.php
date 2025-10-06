<?php
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

include "layout.php";
