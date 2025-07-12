<?php
require_once("../includes/db.php");

$modo_edicion = isset($_GET['id']);
$proveedor = [
    'nombre' => '',
    'contacto' => '',
    'correo' => '',
    'telefono' => '',
    'productos_suministrados' => '',
    'ultima_entrega' => '',
    'estado' => 'Activo'
];

if ($modo_edicion) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM proveedores WHERE id = ?");
    $stmt->execute([$id]);
    $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $contacto = $_POST["contacto"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $productos = $_POST["productos_suministrados"];
    $ultima_entrega = $_POST["ultima_entrega"];
    $estado = $_POST["estado"];

    if ($modo_edicion) {
        $stmt = $conexion->prepare("UPDATE proveedores SET nombre = ?, contacto = ?, correo = ?, telefono = ?, productos_suministrados = ?, ultima_entrega = ?, estado = ? WHERE id = ?");
        $stmt->execute([$nombre, $contacto, $correo, $telefono, $productos, $ultima_entrega, $estado, $id]);
    } else {
        $stmt = $conexion->prepare("INSERT INTO proveedores (nombre, contacto, correo, telefono, productos_suministrados, ultima_entrega, estado) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $contacto, $correo, $telefono, $productos, $ultima_entrega, $estado]);
    }

    header("Location: /roles/administrador/actividades/proveedores.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $modo_edicion ? 'Editar Proveedor' : 'Agregar Proveedor' ?></title>
    <style>
        body {
            background-color: #f4f6fa;
            font-family: Arial, sans-serif;
        }
        .form-container {
            max-width: 600px;
            margin: 60px auto;
            background-color: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }
        h2 {
            text-align: center;
            color: #4370f8;
            margin-bottom: 25px;
        }
        form label {
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-weight: bold;
        }
        form input, form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 10px;
            font-size: 14px;
        }
        form button {
            background-color: #4370f8;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            transition: 0.3s ease;
        }
        form button:hover {
            background-color: #365cd2;
        }
        .btn-cancelar {
            display: inline-block;
            text-align: center;
            margin-top: 15px;
            color: #999;
            text-decoration: none;
            font-size: 14px;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2><?= $modo_edicion ? 'Editar Proveedor' : 'Agregar Proveedor' ?></h2>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($proveedor['nombre']) ?>" required>

            <label>Contacto:</label>
            <input type="text" name="contacto" value="<?= htmlspecialchars($proveedor['contacto']) ?>" required>

            <label>Correo:</label>
            <input type="email" name="correo" value="<?= htmlspecialchars($proveedor['correo']) ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($proveedor['telefono']) ?>" required>

            <label>Productos Suministrados:</label>
            <input type="number" name="productos_suministrados" value="<?= htmlspecialchars($proveedor['productos_suministrados']) ?>" required>

            <label>Última entrega:</label>
            <input type="date" name="ultima_entrega" value="<?= htmlspecialchars($proveedor['ultima_entrega']) ?>" required>

            <label>Estado:</label>
            <select name="estado" required>
                <option value="Activo" <?= $proveedor['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Inactivo" <?= $proveedor['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>

            <button type="submit"><?= $modo_edicion ? 'Guardar Cambios' : 'Agregar Proveedor' ?></button>
            <a href="/roles/administrador/actividades/proveedores.php" class="btn-cancelar">Cancelar</a>
        </form>
    </div>
</body>
</html>
