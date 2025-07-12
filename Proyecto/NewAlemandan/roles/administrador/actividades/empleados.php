<?php
require_once("../../../includes/db.php");

$stmt = $conexion->query("SELECT * FROM empleados ORDER BY id DESC");
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alemandan CRM - Empleados</title>
    <link rel="stylesheet" href="/assets/css/estildas.css" />
    <link rel="stylesheet" href="/assets/css/empleados.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/assets/img/Alogo2.png" class="left-img" alt="Logo Alemandan" width="180px">
        </div>

        <div class="nav-menu">
            <a href="/roles/administrador/dashboard_admin.php" class="nav-item"><i class="fas fa-home"></i><span>Inicio</span></a>
            <a href="/roles/administrador/actividades/inventario.php" class="nav-item"><i class="fas fa-wallet"></i><span>Inventario</span></a>
            <a href="/roles/administrador/actividades/empleados.php" class="nav-item active"><i class="fas fa-sliders-h"></i><span>Empleados</span></a>
            <a href="/roles/administrador/actividades/proveedores.php" class="nav-item"><i class="fas fa-comment-dots"></i><span>Proveedores</span></a>
            <a href="/roles/administrador/actividades/ventas.php" class="nav-item"><i class="fas fa-chart-line"></i><span>Ventas</span></a>
            <a href="/main pages/index.php" class="nav-item"><i class="fas fa-life-ring"></i><span>Cerrar sesión</span></a>
        </div>
    </div>

    <div class="main-content">
        <div class="dashboard-container">
            <div class="dashboard-main">
                <div class="transfer-cards">
                    <div class="transfer-card">
                        <div class="card-icon">
                            <img src="/assets/img/editar4.jpg" alt="Empleado" class="card-icon-img">
                        </div>
                        <p class="card-title">Panel de Control-Empleados</p>
                        <h2 class="card-amount"> Agregar/Modificar </h2>
                        <a href="/forms/agregar_empleado.php" class="editar-btn">Vamoss!</a>
                    </div>

                </div>

                <div class="employees-section">
                    <h2 class="section-title">Listado de Empleados</h2>
                    <div class="employees-container">
                        <?php foreach ($empleados as $empleado): ?>
                            <div class="employee-card">
                                <div class="employee-header">
                                    <img src="/assets/img/profile.jpg" alt="Empleado" class="employee-avatar">
                                    <div class="employee-info">
                                        <h3 class="employee-name"><?= htmlspecialchars($empleado['nombre']) ?></h3>
                                        <span class="employee-position"><?= htmlspecialchars($empleado['cargo']) ?></span>
                                    </div>
                                </div>
                                <div class="employee-details">
                                    <p><i class="fas fa-id-card"></i> ID: EMP<?= str_pad($empleado['id'], 3, '0', STR_PAD_LEFT) ?></p>
                                    <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($empleado['correo']) ?></p>
                                    <p><i class="fas fa-phone"></i> <?= htmlspecialchars($empleado['telefono']) ?></p>
                                    <p><i class="fas fa-calendar-alt"></i> Fecha de ingreso: <?= htmlspecialchars($empleado['fecha_ingreso']) ?></p>
                                </div>
                                <div class="employee-status">
                                    <div class="status-indicator <?= strtolower($empleado['estado']) ?>">
                                        <div class="status-dot <?= strtolower($empleado['estado']) ?>"></div>
                                        <span><?= $empleado['estado'] ?></span>
                                    </div>
                                    <div class="employee-actions">
                                        <a href="/forms/agregar_empleado.php?id=<?= $empleado['id'] ?>" class="action-btn edit"><i class="fas fa-edit"></i></a>
                                        <a href="/forms/eliminar_empleado.php?id=<?= $empleado['id'] ?>" class="action-btn delete"><i class="fas fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if (empty($empleados)): ?>
                            <p style="text-align:center;">No hay empleados registrados.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
