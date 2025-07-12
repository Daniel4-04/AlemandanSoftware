<?php
require_once('../../../includes/db.php');

// Obtener productos desde la base de datos
$stmt = $conexion->query("SELECT * FROM productos ORDER BY ultima_actualizacion DESC");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Inventario - Alemandan CRM</title>
    <link rel="stylesheet" href="/assets/css/dashboards.css" />
    <link rel="stylesheet" href="/assets/css/inventario.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="/assets/img/Alogo2.png" width="180px" alt="Logo">
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
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1>Inventario de Productos</h1>
            <a href="/forms/agregar_producto.php" class="editar-btn">+ Agregar Producto</a>
        </div>

        <div class="products-section">
            <div class="products-container">
                <?php foreach ($productos as $producto): ?>
                    <div class="product-card">
                        <div class="product-header">
                            <h3 class="product-name"><?= htmlspecialchars($producto['nombre']) ?></h3>
                            <span class="product-id">#<?= $producto['id'] ?></span>
                        </div>
                        <div class="product-details">
                            <p><i class="fas fa-tag"></i> Categoría: <?= htmlspecialchars($producto['categoria']) ?></p>
                            <p><i class="fas fa-box"></i> Stock: <?= $producto['stock'] ?> unidades</p>
                            <p><i class="fas fa-dollar-sign"></i> Precio: $<?= number_format($producto['precio'], 2) ?></p>
                            <p><i class="fas fa-calendar"></i> Última actualización: <?= $producto['ultima_actualizacion'] ?></p>
                        </div>
                        <div class="product-actions">
                            <a href="/forms/editar_producto.php?id=<?= $producto['id'] ?>" class="action-btn edit">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="/forms/eliminar_producto.php?id=<?= $producto['id'] ?>" class="action-btn delete" onclick="return confirm('¿Eliminar este producto?');">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>
