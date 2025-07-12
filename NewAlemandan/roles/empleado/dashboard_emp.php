<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['id_cargo'] != 2) {
    header("Location: /includes/login.php");
    exit;
}
$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alemandan CRM - Empleado</title>
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
            <a href="/roles/empleado/dashboard_emp.php" class="nav-item active">
                <i class="fas fa-home"></i>
                <span>Inicio</span>
            </a>
            <a href="/roles/empleado/actividades/caja.php" class="nav-item">
                <i class="fas fa-cash-register"></i>
                <span>Caja</span>
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

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div class="welcome-section">
                <p class="greeting">Buenos días, <?php echo $usuario; ?></p>
                <h1 class="welcome-title">Tu panel de empleado</h1>
            </div>

            <div class="header-right">
                <div class="notification-bell">
                    <i class="fas fa-bell"></i>
                    <div class="notification-indicator">3</div>
                </div>

                <div class="user-profile">
                    <img src="/assets/img/profile.jpg" alt="<?php echo $usuario; ?>" class="profile-pic">
                    <div class="user-info">
                        <div class="user-name"><?php echo $usuario; ?></div>
                        <div class="user-role">Empleado</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Container -->
        <div class="dashboard-container">
            <!-- Main Dashboard Content -->
            <div class="dashboard-main">
                <!-- Employee Cards -->
                <div class="employee-cards">
                    <div class="employee-card">
                        <div class="card-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                        <p class="card-title">Notificaciones</p>
                        <h2 class="card-amount">3</h2>
                        <p class="card-subtitle">Del jefe</p>
                    </div>

                    <div class="employee-card">
                        <div class="card-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <p class="card-title">Tareas especiales</p>
                        <h2 class="card-amount">1</h2>
                        <p class="card-subtitle">Pendientes</p>
                    </div>

                    <div class="employee-card">
                        <div class="card-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <p class="card-title">Horario hoy</p>
                        <h2 class="card-amount">11:00 - 17:00</h2>
                        <p class="card-subtitle">6 horas</p>
                    </div>
                </div>

                <!-- Employee Sections -->
                <div class="employee-sections">
                    <!-- Comisiones Section -->
                    <div class="employee-card large">
                        <h3 class="section-title">
                            <i class="fas fa-money-bill-wave"></i> Comisiones
                        </h3>
                        
                        <div class="transaction-item">
                            <div class="transaction-icon success">
                                <i class="fas fa-coins"></i>
                            </div>
                            <div class="transaction-content">
                                <div class="transaction-title">Horas extra</div>
                                <div class="transaction-time">18/07/2023</div>
                            </div>
                            <div class="transaction-amount positive">+$78.000</div>
                        </div>

                        <div class="transaction-item">
                            <div class="transaction-icon success">
                                <i class="fas fa-medal"></i>
                            </div>
                            <div class="transaction-content">
                                <div class="transaction-title">Cumplimiento de metas</div>
                                <div class="transaction-time">24/07/2023</div>
                            </div>
                            <div class="transaction-amount positive">+$125.000</div>
                        </div>

                        <div class="transaction-total">
                            <span>Total este mes:</span>
                            <span class="total-amount">$1.467.500</span>
                        </div>
                    </div>

                    <!-- Solicitudes Section -->
                    <div class="employee-card large">
                        <h3 class="section-title">
                            <i class="fas fa-paper-plane"></i> Mis solicitudes
                        </h3>
                        
                        <div class="request-item">
                            <div class="request-icon warning">
                                <i class="fas fa-exchange-alt"></i>
                            </div>
                            <div class="request-content">
                                <div class="request-title">Cambio de turno</div>
                                <div class="request-status pending">En revisión</div>
                                <div class="request-time">Enviada: 15/07/2023</div>
                            </div>
                        </div>

                        <div class="request-item">
                            <div class="request-icon primary">
                                <i class="fas fa-umbrella-beach"></i>
                            </div>
                            <div class="request-content">
                                <div class="request-title">Solicitud de vacaciones</div>
                                <div class="request-status approved">Aprobada</div>
                                <div class="request-time">Enviada: 10/07/2023</div>
                            </div>
                        </div>

                        <a href="novedadf.php" class="new-request-btn">
                            <i class="fas fa-plus"></i> Nueva solicitud
                        </a>
                    </div>
                </div>
            </div>

            <!-- Dashboard Sidebar -->
            <div class="dashboard-sidebar">
                <!-- Horario Section -->
                <div class="employee-card">
                    <h3 class="section-title">
                        <i class="fas fa-calendar-week"></i> Mi horario
                    </h3>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">Lunes</div>
                        <div class="schedule-hours">09:00 - 18:00</div>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">Martes</div>
                        <div class="schedule-hours">09:00 - 18:00</div>
                    </div>
                    
                    <div class="schedule-item today">
                        <div class="schedule-day">Miércoles</div>
                        <div class="schedule-hours">11:00 - 17:00</div>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">Jueves</div>
                        <div class="schedule-hours">09:00 - 18:00</div>
                    </div>
                    
                    <div class="schedule-item">
                        <div class="schedule-day">Viernes</div>
                        <div class="schedule-hours">09:00 - 16:00</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
