<?php

/**
 * Genera una plantilla HTML
 */
function generarPaginaHTML($titulo, $contenido)
{
    $res = "
    <!DOCTYPE html>
    <html>
    <head>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet'>
    <title>$titulo</title>
    </head>
    <body>
    <div class='container'>
    $contenido
    </div>
    </body>
    </html>";

    return $res;
}
/**
 * Genera Formulario HTML de acceso
 */
function generarFormularioLogin()
{
    return "
    <h2 class='text-success text-center mt-4'>LOGIN</h2>
    <form method='POST' action='procesar_acceso.php'>
        <div class='form-group'>
        <input type='hidden' name='login' value='login'>
        <label for='usuario' class='form-check-label'>Usuario:</label>
        <input type='text' class='form-control' name='usuario' required><br><br>
        <label for='credencial' class='form-check-label'>Contraseña:</label>
        <input type='credencial' class='form-control' name='credencial' required><br><br>
        <input type='submit' class='btn btn-primary' value='Iniciar sesión'>
        </div>
    </form>";
}
/**
 * Genera formulario de salida
 */
function generarLogout()
{
    return "
    <form method='POST' action='procesar_acceso.php'>
        <input type='hidden' name='logout' value='logout'>
        <input type='submit' value='Cerrar sesión'>
    </form>";
}
