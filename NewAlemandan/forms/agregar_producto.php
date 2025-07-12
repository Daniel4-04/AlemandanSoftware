<?php
require_once("../includes/db.php");



$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $categoria = $_POST['categoria'];
    $stock = $_POST['stock'];
    $precio = $_POST['precio'];
    $fecha = date('Y-m-d');

    $stmt = $conexion->prepare("INSERT INTO productos (nombre, categoria, stock, precio, ultima_actualizacion) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $categoria, $stock, $precio, $fecha]);

    $mensaje = 'Producto agregado correctamente.';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Agregar Producto</title>
    <link rel="stylesheet" href="/assets/css/inventario.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f8;
        }

        .form-container {
            max-width: 400px;
            margin: 60px auto;
            background: white;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 20px;
            text-align: center;
        }

        input, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }

        button {
            background-color: #005b96;
            color: white;
            border: none;
            cursor: pointer;
        }

        a {
            text-decoration: none;
            color: #005b96;
        }

        p {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Agregar Nuevo Producto</h2>
        <?php if ($mensaje): ?>
            <p style="color: green;"><?= $mensaje ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre del producto" required>
            <input type="text" name="categoria" placeholder="Categoría" required>
            <input type="number" name="stock" placeholder="Stock" required>
            <input type="number" step="0.01" name="precio" placeholder="Precio" required>
            <button type="submit">Guardar</button>
        </form>
        <p><a href="/roles/administrador/actividades/inventario.php">← Volver al inventario</a></p>
    </div>
</body>
</html>
