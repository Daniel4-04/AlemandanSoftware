<?php
require_once("../includes/db.php");

$modo_confirmacion = isset($_GET['id']);
$empleado = [
    'nombre' => '',
    'correo' => '',
    'telefono' => '',
    'cargo' => '',
    'fecha_ingreso' => '',
    'estado' => 'Activo'
];

if ($modo_confirmacion) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("SELECT * FROM empleados WHERE id = ?");
    $stmt->execute([$id]);
    $empleado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$empleado) {
        header("Location: /roles/administrador/actividades/empleados.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirmar'])) {
    $id = $_POST["id"];
    $stmt = $conexion->prepare("DELETE FROM empleados WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: /roles/administrador/actividades/empleados.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Empleado</title>
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
            text-align: center;
        }

        h2 {
            color: #f36c6c;
            margin-bottom: 25px;
        }

        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 25px;
        }

        .btn-danger {
            background-color: #f36c6c;
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

        .btn-danger:hover {
            background-color: #d04545;
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
        <h2>¿Eliminar Empleado?</h2>
        <p>Estás a punto de eliminar al empleado <strong><?= htmlspecialchars($empleado['nombre']) ?></strong> con correo <strong><?= htmlspecialchars($empleado['correo']) ?></strong>.</p>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $empleado['id'] ?>">
            <button type="submit" name="confirmar" class="btn-danger">Eliminar</button>
        </form>

        <a href="/roles/administrador/actividades/empleados.php" class="btn-cancelar">Cancelar</a>
    </div>
</body>
</html>
