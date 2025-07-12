<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['id_cargo'] != 1) {
    header("Location: /main pages/login.php");  
    exit;
}
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alemandan CRM - Cuenta de Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/dashboards.css"> 
    <style>
        /* Estilos para el recuadro de ayuda */
        .help-popup {
            display: none;
            position: fixed;
            top: 60px;
            left: 240px;
            right: 40px;
            bottom: 60px;
            background: #fff;
            border: 2px solid #007bff;
            padding: 25px;
            z-index: 999;
            overflow-y: auto;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }

        .help-popup h2 {
            margin-top: 0;
            color: #007bff;
        }

        .help-popup section {
            margin-bottom: 20px;
        }

        .help-popup .close-help {
            float: right;
            font-size: 18px;
            cursor: pointer;
            color: #888;
        }

        .help-popup .close-help:hover {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="/assets/img/Alogo2.png" class="left-img" alt="Logo Alemandan" width="180px">
        </div>

        <div class="nav-menu">
            <a href="/roles/administrador/dashboard_admin.php" class="nav-item"><i class="fas fa-home"></i><span>Inicio</span></a>
            <a href="/roles/administrador/actividades/inventario.php" class="nav-item"><i class="fas fa-wallet"></i><span>Inventario</span></a>
            <a href="/roles/administrador/actividades/empleados.php" class="nav-item"><i class="fas fa-sliders-h"></i><span>Empleados</span></a>
            <a href="/roles/administrador/actividades/proveedores.php" class="nav-item"><i class="fas fa-comment-dots"></i><span>Proveedores</span></a>
            <a href="/roles/administrador/actividades/ventas.php" class="nav-item"><i class="fas fa-chart-line"></i><span>Ventas</span></a>
            <a href="/includes/logout.php" class="nav-item"><i class="fas fa-sign-out-alt"></i><span>Cerrar sesión</span></a>
        </div>

        <div class="premium-box">
            <h3>Centro de ayuda</h3>
            <button class="premium-btn" onclick="mostrarAyuda()">Alemandan te respalda</button>
        </div>
    </div>

    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="welcome-section">
                <p class="greeting">Hola, <?php echo $usuario; ?></p>
                <h1 class="welcome-title">Tu cuenta de administrador</h1>
            </div>
            <div class="header-right">
                <div class="notification-bell"><i class="fas fa-bell"></i><div class="notification-indicator"></div></div>
                <div class="user-profile">
                    <img src="/assets/img/profile.jpg" alt="<?php echo $usuario; ?>" class="profile-pic">
                    <div class="user-info">
                        <div class="user-name"><?php echo $usuario; ?></div>
                        <div class="user-role">Administrador</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cuenta Container -->
        <div class="account-container">
            <div class="account-card profile-section">
                <div class="profile-header">
                    <div class="profile-img-container">
                        <img src="/assets/img/profile.jpg" alt="<?php echo $usuario; ?>" class="profile-img-large">
                        <div class="admin-badge"><i class="fas fa-crown"></i></div>
                    </div>
                    <div class="profile-info">
                        <h2><?php echo $usuario; ?></h2>
                        <p><i class="fas fa-envelope"></i> admin@alemandan.com</p>
                        <p><i class="fas fa-phone"></i> +57 321 555 7890</p>
                        <p><i class="fas fa-map-marker-alt"></i> Medellín, Colombia</p>
                    </div>
                </div>
                <div class="account-stats">
                    <div class="stat-card"><h3>Empleados</h3><p>24</p></div>
                    <div class="stat-card"><h3>Proveedores</h3><p>12</p></div>
                    <div class="stat-card"><h3>Roles asignados</h3><p>8</p></div>
                    <div class="stat-card"><h3>Sistema activo</h3><p>256 días</p></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recuadro de ayuda -->
    <div class="help-popup" id="ayuda">
        <span class="close-help" onclick="cerrarAyuda()">✖</span>
        <h2>Centro de Ayuda - Alemandan CRM</h2>

        <section>
            <h3>📦 Inventario</h3>
            <p>Aquí puedes ver todos los productos disponibles, editar su información, actualizar precios, modificar stock y eliminar productos que ya no estén en uso.</p>
        </section>

        <section>
            <h3>👥 Empleados</h3>
            <p>Este módulo permite agregar, editar y eliminar empleados. Además puedes asignar roles como "Administrador" o "Empleado" según corresponda.</p>
        </section>

        <section>
            <h3>📨 Proveedores</h3>
            <p>Gestiona los proveedores que surten tus productos. Puedes registrar nuevos proveedores, ver sus datos de contacto y eliminarlos si ya no colaboran con la tienda.</p>
        </section>

        <section>
            <h3>📈 Ventas</h3>
            <p>Visualiza todas las ventas realizadas. Puedes aplicar filtros por producto, cajero, fechas y método de pago. Además, puedes exportar los resultados filtrados a Excel o PDF directamente desde este módulo.</p>
        </section>

        <p style="margin-top: 20px;"><strong>¿Necesitas más ayuda?</strong> Contacta con el equipo de soporte de Alemandan.</p>
    </div>

    <script>
        function mostrarAyuda() {
            document.getElementById("ayuda").style.display = "block";
        }

        function cerrarAyuda() {
            document.getElementById("ayuda").style.display = "none";
        }
    </script>
</body>
</html>
