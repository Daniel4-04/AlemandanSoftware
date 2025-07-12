<?php
require_once("../includes/db.php");

$modo_edicion = isset($_GET['id']);
$empleado = [
    'nombre' => '',
    'correo' => '',
    'telefono' => '',
    'cargo' => '',
    'fecha_ingreso' => '',
    'estado' => 'Activo'
];

if ($modo_edicion) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM empleados WHERE id = ?");
    $stmt->execute([$id]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $cargo = $_POST["cargo"];
    $fecha_ingreso = $_POST["fecha_ingreso"];
    $estado = $_POST["estado"];

    if ($modo_edicion) {
        $stmt = $conexion->prepare("UPDATE empleados SET nombre = ?, correo = ?, telefono = ?, cargo = ?, fecha_ingreso = ?, estado = ? WHERE id = ?");
        $stmt->execute([$nombre, $correo, $telefono, $cargo, $fecha_ingreso, $estado, $id]);
    } else {
        $stmt = $conexion->prepare("INSERT INTO empleados (nombre, correo, telefono, cargo, fecha_ingreso, estado) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nombre, $correo, $telefono, $cargo, $fecha_ingreso, $estado]);
    }

    header("Location: /roles/administrador/actividades/empleados.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $modo_edicion ? 'Editar Empleado' : 'Agregar Empleado' ?></title>
    <link rel="stylesheet" href="/assets/css/formulario_empleado.css">
    <style>
        body {
    background-color: #f4f6fa;
    font-family: Arial, sans-serif;
}

.form-container {
    max-width: 500px;
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

form input,
form select {
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
        <h2><?= $modo_edicion ? 'Editar Empleado' : 'Agregar Empleado' ?></h2>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($empleado['nombre']) ?>" required>

            <label>Correo:</label>
            <input type="email" name="correo" value="<?= htmlspecialchars($empleado['correo']) ?>" required>

            <label>Teléfono:</label>
            <input type="text" name="telefono" value="<?= htmlspecialchars($empleado['telefono']) ?>" required>

            <label>Cargo:</label>
            <input type="text" name="cargo" value="<?= htmlspecialchars($empleado['cargo']) ?>" required>

            <label>Fecha de Ingreso:</label>
            <input type="date" name="fecha_ingreso" value="<?= htmlspecialchars($empleado['fecha_ingreso']) ?>" required>

            <label>Estado:</label>
            <select name="estado" required>
                <option value="Activo" <?= $empleado['estado'] === 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Inactivo" <?= $empleado['estado'] === 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>

            <button type="submit"><?= $modo_edicion ? 'Guardar Cambios' : 'Agregar Empleado' ?></button>
            <a href="/roles/administrador/actividades/empleados.php" class="btn-cancelar">Cancelar</a>
        </form>
    </div>
</body>
</html>
