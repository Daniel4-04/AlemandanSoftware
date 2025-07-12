<?php
require_once("../includes/db_connection.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST["nombre"];
    $usuario = $_POST["usuario"];
    $contrasena = $_POST["contrasena"];
    $id_cargo = $_POST["id_cargo"];

    // Verificar si el usuario ya existe
    $verificar = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $verificar->bind_param("s", $usuario);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($resultado->num_rows > 0) {
        $mensaje = "El usuario ya existe.";
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, usuario, contraseña, id_cargo) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $nombre, $usuario, $contrasena, $id_cargo);
        if ($stmt->execute()) {
            // Redirige al login con mensaje de éxito
            header("Location: login.php?registro=exitoso");
            exit;
        } else {
            $mensaje = "Error al registrar usuario.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="/assets/css/registro_usuarios.css">
</head>
<body>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div>
                    <h3>Crear nuevo usuario</h3>
                    <p>Registra un administrador o empleado</p>
                </div>
            </div>

            <div class="contenedor__login-register">
                <form class="formulario__login" method="POST" action="">
                    <h2>Registro de Usuario</h2>
                    <input type="text" name="nombre" placeholder="Nombre completo" required>
                    <input type="text" name="usuario" placeholder="Nombre de usuario" required>
                    <input type="password" name="contrasena" placeholder="Contraseña" required>
                    <select name="id_cargo" required>
                        <option value="">Selecciona un rol</option>
                        <option value="1">Administrador</option>
                        <option value="2">Empleado</option>
                    </select>
                    <button type="submit">Registrar</button>
                    <?php if (!empty($mensaje)): ?>
                        <p class="mensaje"><?php echo $mensaje; ?></p>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
