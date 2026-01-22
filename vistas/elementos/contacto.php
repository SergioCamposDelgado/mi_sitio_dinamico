<<<<<<< HEAD:elementos/contacto.php
<h2 class="text-success text-center mt-4">Contactos</h2>
<ul class="list-group">
    <?php
    $contactos = ["611-11-11-11", "correo@ejemplo.net", "Calle inventada n7, Camas, Sevilla", "www.paginaweb.net"];
    foreach ($contactos as $c) {
        echo "<li class='list-group-item'>" . htmlspecialchars($c) . "</li>";
    }
    ?>
</ul>
=======
<?php
/**
 * ========================================================
 * 📬 Vista: contacto.php
 * Propósito: ejecutar el seeding de usuarios de prueba.
 * Autor: profeinformatica101
 * ========================================================
 */

// Ruta correcta al seeder
require_once __DIR__ . '/../../nucleo/Datos.php';

// Ejecutar silenciosamente el seeding
ob_start();
$filasUsuarios = seedUsuariosDatos(true);   // o Utiles::seedUsuarios();
ob_end_clean();

// Mostrar resultado simple (en texto o HTML)
echo "<div style='font-family:monospace; background:#111; color:#0f0; padding:1rem; border-radius:8px;'>";
echo "🌱 Ejecutado <strong>seedUsuariosDatos()</strong><br>";
echo "✅ Usuarios insertados/actualizados: <strong>{$filasUsuarios}</strong><br>";
echo "📂 Archivo origen: <em>nucleo/Datos.php</em>";
echo "</div>";

ob_start();
 $filasProductos= semillaProductosDatos(true);
ob_end_clean();

// Mostrar resultado simple (en texto o HTML)
echo "<div style='font-family:monospace; background:#111; color:#0f0; padding:1rem; border-radius:8px;'>";
echo "🌱 Ejecutado <strong>semillaProductosDatos()</strong><br>";
echo "✅ Usuarios insertados/actualizados: <strong>{$filasProductos}</strong><br>";
echo "📂 Archivo origen: <em>nucleo/Datos.php</em>";
echo "</div>";
exit;
>>>>>>> feature/seleccion-compra:vistas/elementos/contacto.php
