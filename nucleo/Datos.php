<?php

declare(strict_types=1);

// /nucleo/Datos.php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../config.php';

/**
 * Vacía una tabla de forma segura (MySQL).
 * Nota: TRUNCATE hace commit implícito; por eso debe ejecutarse fuera de una transacción.
 */
function resetTabla(PDO $pdo, string $tabla): void
{
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
    $pdo->exec("TRUNCATE TABLE `{$tabla}`");
    $pdo->exec('SET FOREIGN_KEY_CHECKS = 1');
}

/**
 * 🌱 Inserta productos de prueba.
 * - Si $reset = true, vacía la tabla antes de insertar.
 * - Devuelve el número aproximado de filas afectadas.
 */
function semillaProductosDatos(bool $reset = false): int
{
    $pdo = Database::getConnection();
    $afectadas = 0;

    $productos = [
        [
            'producto'    => 'Pan de Camas',
            'precio'      => 1.20,
            'stock'       => 48,
            'descripcion' => 'Pan artesano elaborado con masa madre y harina de trigo local. Horno de leña tradicional de Camas.'
        ],
        [
            'producto'    => 'Aceitunas aliñadas de Camas',
            'precio'      => 2.50,
            'stock'       => 37,
            'descripcion' => 'Aceitunas gordales partidas y aliñadas con pimiento, ajo, tomillo y aceite de oliva virgen extra. Receta tradicional de la comarca.'
        ],
        [
            'producto'    => 'Tortas de aceite',
            'precio'      => 3.00,
            'stock'       => 62,
            'descripcion' => 'Tortas de aceite crujientes con un toque de anís y sésamo. Elaboradas a mano en obrador sevillano. Pack de 6 unidades.'
        ],
        [
            'producto'    => 'Aceite Virgen Extra “Aljarafe”',
            'precio'      => 6.80,
            'stock'       => 19,
            'descripcion' => 'AOVE coupage de arbequina y manzanilla. Frutado medio, notas de tomate y almendra. Botella de 500 ml.'
        ],
        [
            'producto'    => 'Jamón ibérico de recebo',
            'precio'      => 12.50,
            'stock'       => 8,
            'descripcion' => 'Jamón de bellota 50% raza ibérica. Curación mínima 24 meses. Loncheado a cuchillo. Sobre de 100 g.'
        ],
        [
            'producto'    => 'Queso de cabra payoya',
            'precio'      => 4.75,
            'stock'       => 25,
            'descripcion' => 'Queso curado de leche cruda de cabra payoya de la Sierra de Cádiz. Sabor intenso y textura cremosa. Pieza de 300 g aprox.'
        ],
        [
            'producto'    => 'Miel de azahar del Aljarafe',
            'precio'      => 5.20,
            'stock'       => 41,
            'descripcion' => 'Miel monofloral de azahar recolectada en primavera. Dulce y aromática. Tarro de 500 g.'
        ],
        [
            'producto'    => 'Almendras fritas estilo barra',
            'precio'      => 3.40,
            'stock'       => 53,
            'descripcion' => 'Almendras marcona fritas con sal marina. El aperitivo clásico de cualquier bar sevillano. Bolsa de 200 g.'
        ],
        [
            'producto'    => 'Bollos de anís tradicionales',
            'precio'      => 2.30,
            'stock'       => 35,
            'descripcion' => 'Bollitos dulces con aroma intenso a matalahúva. Receta de abuela. Pack de 8 unidades.'
        ],
        [
            'producto'    => 'Paté de aceituna verde',
            'precio'      => 3.10,
            'stock'       => 29,
            'descripcion' => 'Paté untable elaborado con aceitunas manzanilla y especias. Perfecto para canapés. Tarro de 120 g.'
        ],
        [
            'producto'    => 'Vino blanco DO “Aljarafe”',
            'precio'      => 8.50,
            'stock'       => 14,
            'descripcion' => 'Vino blanco joven de uva garría. Fresco, afrutado y con toque cítrico. Botella 75 cl. Añada 2024.'
        ],
        [
            'producto'    => 'Dulce de membrillo artesano',
            'precio'      => 2.90,
            'stock'       => 44,
            'descripcion' => 'Membrillo casero cocido lentamente con azúcar de caña. Ideal con queso curado. Tarrina de 250 g.'
        ],
        [
            'producto'    => 'Anchoas en aceite de oliva',
            'precio'      => 7.20,
            'stock'       => 22,
            'descripcion' => 'Anchoas del Cantábrico en aceite de oliva virgen extra. Filetes grandes y jugosos. Lata de 50 g.'
        ],
        [
            'producto'    => 'Chorizo casero del Aljarafe',
            'precio'      => 4.60,
            'stock'       => 31,
            'descripcion' => 'Chorizo curado de cerdo ibérico con pimentón de la Vera. Pieza de 400 g aprox.'
        ],
        [
            'producto'    => 'Flor de sal del Guadalquivir',
            'precio'      => 2.70,
            'stock'       => 58,
            'descripcion' => 'Sal marina natural recolectada a mano en las salinas del Guadalquivir. Escamas crujientes. Tarro de 100 g.'
        ],
        [
            'producto'    => 'Mermelada de higo de la zona',
            'precio'      => 3.30,
            'stock'       => 27,
            'descripcion' => 'Mermelada extra de higos frescos del Aljarafe. 70% fruta. Sin conservantes. Tarro de 300 g.'
        ],
        [
            'producto'    => 'Cervezas artesanas sevillanas',
            'precio'      => 2.80,
            'stock'       => 72,
            'descripcion' => 'Pack de 3 botellas 33 cl: IPA, Rubia y Tostada. Elaboradas con agua del Aljarafe.'
        ],
        [
            'producto'    => 'Tomate seco en aceite',
            'precio'      => 4.20,
            'stock'       => 18,
            'descripcion' => 'Tomates secados al sol y conservados en AOVE con albahaca. Tarro de 200 g.'
        ],
        [
            'producto'    => 'Aceite arbequina 250 ml',
            'precio'      => 5.60,
            'stock'       => 33,
            'descripcion' => 'Aceite de oliva virgen extra 100% arbequina. Frutado verde intenso. Botella cristal 250 ml.'
        ],
        [
            'producto'    => 'Picos de pan artesanos',
            'precio'      => 1.80,
            'stock'       => 89,
            'descripcion' => 'Picos de pan crujientes elaborados con AOVE. Perfectos para picoteo. Bolsa de 200 g.'
        ],
    ];

    // Si vas a resetear, hazlo SIEMPRE fuera de la transacción
    if ($reset) {
        resetTabla($pdo, 'productos');
    }

    $sql = "INSERT INTO productos (nombre, precio, stock, descripcion) VALUES (:nombre, :precio, :stock, :descripcion)";
    $stmt = $pdo->prepare($sql);

    try {
        $pdo->beginTransaction();

        foreach ($productos as $p) {
            $stmt->execute([
                ':nombre' => (string)($p['producto'] ?? ''),
                ':precio' => (float)($p['precio'] ?? 0.0),
                ':stock' => (int)($p['stock'] ?? 0),
                ':descripcion' => (string)($p['descripcion'] ?? ''),
            ]);
            $afectadas += $stmt->rowCount();
        }

        $pdo->commit();
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Seed productos error: ' . $e->getMessage());
        return 0;
    }

    return $afectadas;
}

/**
 * 🌱 Inserta usuarios de prueba.
 * - Si $reset = true, vacía la tabla antes de insertar.
 * - Devuelve el número aproximado de filas afectadas.
 */
function seedUsuariosDatos(bool $reset = false): int
{
    $pdo = Database::getConnection();
    $afectadas = 0;

    $usuarios = [
        ['admin',    'admin123', 'Administrador General', 'admin'],
        ['manager1', 'manager1', 'Laura Gestora',         'manager'],
        ['manager2', 'manager2', 'Carlos Supervisor',     'manager'],
        ['user1',    'user1',    'María Compradora',      'usuario'],
        ['user2',    'user2',    'Pedro Cliente',         'usuario'],
        ['user3',    'user3',    'Lucía Compradora',      'usuario'],
        ['user4',    'user4',    'Manuel Perez',          'usuario'],
        ['user5',    'user5',    'Tess test',          'usuario'],
    ];

    if ($reset) {
        resetTabla($pdo, 'usuarios');
    }

    $sql = "INSERT INTO usuarios (usuario, password, nombre, rol)
            VALUES (:usuario, :password, :nombre, :rol)";
    $stmt = $pdo->prepare($sql);

    try {
        $pdo->beginTransaction();

        foreach ($usuarios as [$usuario, $clave, $nombre, $rol]) {
            $stmt->execute([
                ':usuario'  => $usuario,
                ':password' => password_hash($clave, PASSWORD_DEFAULT),
                ':nombre'   => $nombre,
                ':rol'      => $rol,
            ]);
            $afectadas += $stmt->rowCount();
        }

        $pdo->commit();
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        error_log('Seed usuarios error: ' . $e->getMessage());
        return 0;
    }

    return $afectadas;
}
