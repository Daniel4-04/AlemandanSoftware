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
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="/assets/img/Alogo2.png" class="left-img" alt="Logo Alemandan" width="180px">
        </div>

        <div class="nav-menu">
            <a href="/roles/administrador/dashboard_admin.php" class="nav-item">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
            <a href="/roles/administrador/actividades/inventario.php" class="nav-item">
                <i class="fas fa-wallet"></i>
                <span>Inventario</span>
            </a>
            <a href="/roles/administrador/actividades/empleados.php" class="nav-item">
                <i class="fas fa-sliders-h"></i>
                <span>Empleados</span>
            </a>
            <a href="/roles/administrador/actividades/proveedores.php" class="nav-item">
                <i class="fas fa-comment-dots"></i>
                <span>Proveedores</span>
            </a>
            <a href="/roles/administrador/actividades/ventas.php" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Ventas</span>
            </a>
            <a href="/includes/logout.php" class="nav-item">
                <i class="fas fa-sign-out-alt"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>

        <div class="premium-box">
            <h3>Centro de ayuda</h3>
            <button class="premium-btn">Alemandan te respalda</button>
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
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <div class="notification-indicator"></div>
                </div>

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
            <!-- Perfil Section -->
            <div class="account-card profile-section">
                <div class="profile-header">
                    <div class="profile-img-container">
                        <img src="/assets/img/profile.jpg" alt="<?php echo $usuario; ?>" class="profile-img-large">
                        <div class="admin-badge">
                            <i class="fas fa-crown"></i>
                        </div>
                    </div>
                    <div class="profile-info">
                        <h2><?php echo $usuario; ?></h2>
                        <p><i class="fas fa-envelope"></i> admin@alemandan.com</p>
                        <p><i class="fas fa-phone"></i> +57 321 555 7890</p>
                        <p><i class="fas fa-map-marker-alt"></i> Medellín, Colombia</p>
                    </div>
                </div>
                
                <div class="account-stats">
                    <div class="stat-card">
                        <h3>Empleados</h3>
                        <p>24</p>
                    </div>
                    <div class="stat-card">
                        <h3>Proveedores</h3>
                        <p>12</p>
                    </div>
                    <div class="stat-card">
                        <h3>Roles asignados</h3>
                        <p>8</p>
                    </div>
                    <div class="stat-card">
                        <h3>Sistema activo</h3>
                        <p>256 días</p>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
</body>
</html>
