<?php
session_start();
include('../includes/db_connection.php');

$error_login = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['login'])) {
        $usuario = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];

        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND contraseña = ?");
        $stmt->bind_param("ss", $usuario, $password);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();

            $_SESSION['usuario'] = $usuario['usuario'];
            $_SESSION['id_cargo'] = $usuario['id_cargo'];

            // Redirección según rol
            if ($usuario['id_cargo'] == 1) {
                header("Location: /roles/administrador/dashboard_admin.php");
                exit;
            } elseif ($usuario['id_cargo'] == 2) {
                header("Location: /roles/empleado/dashboard_emp.php");
                exit;
            }
        } else {
            $error_login = "Usuario o contraseña incorrectos.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <style>
        .error-message {
            color: #ff3860;
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <a href="/main pages/index.php" class="btn-volver">← Volver al inicio</a>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>
                    <a href="/main%20pages/registro_usuario.php">
                        <button type="button">Regístrarse</button>
                    </a>
                </div>
            </div>

            <div class="contenedor__login-register">
                <!-- Formulario de Login -->
                <form id="loginForm" class="formulario__login" method="POST" action="">
                    <h2>Iniciar Sesión</h2>
                    <input type="text" name="loginEmail" placeholder="Usuario" required>
                    <input type="password" name="loginPassword" placeholder="Contraseña" required>
                    <?php if (!empty($error_login)): ?>
                        <div class="error-message"><?php echo $error_login; ?></div>
                    <?php endif; ?>
                    <?php if (isset($_GET['registro']) && $_GET['registro'] === 'exitoso'): ?>
                        <div class="success-message">¡Registro exitoso! Ahora puedes iniciar sesión.</div>
                    <?php endif; ?>
                    <button type="submit" name="login">Entrar</button>
                </form>
            </div>
        </div>
    </main>
    <script src="/assets/js/login.js"></script>
</body>
</html>
