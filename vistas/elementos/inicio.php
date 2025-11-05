<?php
require_once __DIR__ . '/plantillas.php';
require_once __DIR__ . '/../../config.php';

$auth = $_SESSION['auth'] ?? null;

function esUser(): bool
{
    return isset($_SESSION['auth']['rol']) && $_SESSION['auth']['rol'] === 'usuario';
}

function esAdmin(): bool
{
    return isset($_SESSION['auth']['rol']) && $_SESSION['auth']['rol'] === 'admin';
}

if ($auth) {

    $contenido  = '<h1>Hola, ' . escaparHTML($auth['nombre']) . ' 👋</h1>';
    $contenido .= '<p>Estás dentro de la sesión.</p>';
    $contenido .= generarLogout(ACTION_URL);

    if (esAdmin()) {
        $contenido .= mostrarListadoUsuarios();
    }
    if (esUser()) {
        $contenido .= "<b> ES USUARIO </b>";
    }
} else {
    $contenido = generarFormularioLogin(ACTION_URL);
}

echo generarPaginaHTML('Inicio de sesión', $contenido);
