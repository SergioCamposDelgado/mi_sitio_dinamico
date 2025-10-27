 <?php
    include_once('plantillas.php');
    session_start();

    if (isset($_SESSION['usuario'])) {
        // Si el usuario ya está logueado, mostramos un mensaje de bienvenida
        header("Location: redirect.php");
        exit(); // Se recomienda usar exit() después de un header() para evitar que el script continúe ejecutándose.
    } else {
        // Si el usuario no está logueado, mostramos el formulario de inicio de sesión
        echo generarPaginaHTML("Ejemplo Mostrar Formulario",  generarFormularioLogin());
    }
    ?>

