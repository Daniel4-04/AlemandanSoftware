<?php
require_once("../../../includes/db.php");

$stmt = $conexion->prepare("SELECT * FROM proveedores");
$stmt->execute();
$proveedores = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alemandan CRM - Proveedores</title>
    <link rel="stylesheet" href="/assets/css/proveedores.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
            <a href="/roles/administrador/actividades/proveedores.php" class="nav-item active">
                <i class="fas fa-comment-dots"></i>
                <span>Proveedores</span>
            </a>
            <a href="/roles/administrador/actividades/ventas.php" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Ventas</span>
            </a>
            <a href="/main pages/index.php" class="nav-item">
                <i class="fas fa-life-ring"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="dashboard-container">
            <div class="dashboard-main">

                <!-- Panel de control proveedores -->
                <div class="transfer-cards">
                    <div class="transfer-card">
                        <img src="/assets/img/editar2.jpg" alt="Editar Proveedor" class="card-img">
                        <p class="card-title">Panel de Control-Proveedores</p>
                        <h2 class="card-amount"> Agregar/Modificar </h2>
                        <a href="/forms/agregar_proveedor.php" class="editar-btn">Vamoss!</a>
                    </div>

                    <div class="transfer-card">
                        <img src="/assets/img/editar2.jpg" alt="Eliminar Proveedor" class="card-img">
                        <p class="card-title">Panel de Control-Proveedores</p>
                        <h2 class="card-amount"> Eliminar </h2>
                        <a href="/forms/eliminar_proveedor.php" class="editar-btn">Vamoss!</a>
                    </div>
                </div>

                <!-- Lista de proveedores -->
                <div class="suppliers-section">
                    <h2 class="section-title">Proveedores Registrados</h2>
                    <div class="suppliers-container">
                        <?php foreach ($proveedores as $prov): ?>
                            <div class="supplier-card">
                                <div class="supplier-header">
                                    <h3 class="supplier-name"><?= htmlspecialchars($prov['nombre']) ?></h3>
                                    <span class="supplier-id">#PROV<?= str_pad($prov['id'], 3, '0', STR_PAD_LEFT) ?></span>
                                </div>
                                <div class="supplier-details">
                                    <p><i class="fas fa-user"></i> Contacto: <?= htmlspecialchars($prov['contacto']) ?></p>
                                    <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($prov['correo']) ?></p>
                                    <p><i class="fas fa-phone"></i> Teléfono: <?= htmlspecialchars($prov['telefono']) ?></p>
                                    <p><i class="fas fa-boxes"></i> Productos Suministrados: <?= htmlspecialchars($prov['productos_suministrados']) ?></p>
                                    <p><i class="fas fa-calendar"></i> Última entrega: <?= htmlspecialchars($prov['ultima_entrega']) ?></p>
                                </div>
                                <div class="supplier-status">
                                    <div class="status-indicator <?= $prov['estado'] === 'Activo' ? 'active' : 'inactive' ?>">
                                        <div class="status-dot <?= $prov['estado'] === 'Activo' ? 'active' : 'inactive' ?>"></div>
                                        <span><?= $prov['estado'] ?></span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
