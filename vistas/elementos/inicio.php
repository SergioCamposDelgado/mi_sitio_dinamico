<<<<<<< HEAD:elementos/inicio.php
<h2 class="text-success text-center mt-4">Pagina Web creada con PHP</h2>
=======
<?php
require_once __DIR__ . '/plantillas.php';
require_once __DIR__ . '/../../config.php';

$auth = $_SESSION['auth'] ?? null;

function esAdmin(): bool {
    return isset($_SESSION['auth']['rol']) && $_SESSION['auth']['rol'] === 'admin';
}

if ($auth) {

    $contenido  = '<h1>Hola, ' . escaparHTML($auth['nombre']) . ' 👋</h1>';
    $contenido .= '<p>Estás dentro de la sesión.</p>';
    $contenido .= generarLogout(ACTION_URL);

    if (esAdmin()) {
        $contenido .= mostrarListadoUsuarios(); 
    }

    $contenido .= '<script src="vistas/js/hola.js"></script>';

} else {
    $contenido = generarFormularioLogin(ACTION_URL);
}

echo generarPaginaHTML('Inicio de sesión', $contenido);
>>>>>>> feature/seleccion-compra:vistas/elementos/inicio.php
