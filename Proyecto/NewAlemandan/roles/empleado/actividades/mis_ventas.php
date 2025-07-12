<?php
session_start();
require_once("../../../includes/db.php");

// Solo empleados pueden acceder
if (!isset($_SESSION['usuario']) || $_SESSION['id_cargo'] != 2) {
    header("Location: /main pages/login.php");
    exit;
}

$cajero = $_SESSION['usuario'];

// Filtros
$filtroProducto = $_GET['producto'] ?? '';
$fechaDesde = $_GET['fecha_desde'] ?? '';
$fechaHasta = $_GET['fecha_hasta'] ?? '';
$metodoPago = $_GET['metodo_pago'] ?? '';

// Consultar solo las ventas de este cajero
$sql = "SELECT * FROM ventas WHERE cajero = :cajero";
$params = [':cajero' => $cajero];

if ($filtroProducto) {
    $sql .= " AND productos LIKE :producto";
    $params[':producto'] = "%$filtroProducto%";
}
if ($fechaDesde && $fechaHasta) {
    $sql .= " AND fecha BETWEEN :desde AND :hasta";
    $params[':desde'] = $fechaDesde;
    $params[':hasta'] = $fechaHasta;
}
if ($metodoPago) {
    $sql .= " AND metodo_pago = :metodo";
    $params[':metodo'] = $metodoPago;
}

$sql .= " ORDER BY fecha DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);
$jsonVentas = json_encode($ventas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Ventas</title>
    <link rel="stylesheet" href="/assets/css/ventas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .filtro-form {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 15px;
        }
        .filtro-form input,
        .filtro-form select,
        .filtro-form button {
            padding: 6px 10px;
            font-size: 14px;
        }
        .user-box {
            background: #f4f6fa;
            border-left: 5px solid #007BFF;
            padding: 12px 16px;
            margin-bottom: 15px;
            font-size: 15px;
            border-radius: 4px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo"><img src="/assets/img/Alogo2.png" alt="Logo Alemandan" width="180"></div>
    <div class="nav-menu">
        <a href="/roles/empleado/dashboard_emp.php" class="nav-item"><i class="fas fa-home"></i>Inicio</a>
        <a href="/roles/empleado/actividades/caja.php" class="nav-item"><i class="fas fa-cash-register"></i>Caja</a>
        <a href="/roles/empleado/actividades/mis_ventas.php" class="nav-item active"><i class="fas fa-chart-bar"></i>Mis Ventas</a>
        <a href="/main pages/index.php" class="nav-item"><i class="fas fa-sign-out-alt"></i>Cerrar sesión</a>
    </div>
</div>

<div class="main-content">
    <div class="dashboard-container">
        <div class="dashboard-main">

            <div class="user-box">
                <strong>Usuario actual:</strong> <?= htmlspecialchars($cajero) ?>  
                <br><small>Estas son tus ventas registradas.</small>
            </div>

            <form method="GET" class="filtro-form">
                <input type="text" name="producto" placeholder="Buscar por producto" value="<?= htmlspecialchars($filtroProducto) ?>">
                <input type="date" name="fecha_desde" value="<?= htmlspecialchars($fechaDesde) ?>">
                <input type="date" name="fecha_hasta" value="<?= htmlspecialchars($fechaHasta) ?>">
                <select name="metodo_pago">
                    <option value="">Método de pago</option>
                    <option value="efectivo" <?= $metodoPago === 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                    <option value="tarjeta" <?= $metodoPago === 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
                    <option value="transferencia" <?= $metodoPago === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                </select>
                <button type="submit">Filtrar</button>
            </form>

            <div class="report-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Método de Pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($ventas) > 0): ?>
                            <?php foreach ($ventas as $venta): ?>
                                <tr>
                                    <td><?= $venta['id'] ?></td>
                                    <td><?= $venta['fecha'] ?></td>
                                    <td>
                                        <?php
                                        $productos = json_decode($venta['productos'], true);
                                        if (is_array($productos)) {
                                            foreach ($productos as $p) {
                                                echo "🔸 {$p['nombre']} x{$p['cantidad']} - $" . number_format($p['precio'], 0, ',', '.') . "<br>";
                                            }
                                        } else {
                                            echo htmlspecialchars($venta['productos']);
                                        }
                                        ?>
                                    </td>
                                    <td>$<?= number_format($venta['total'], 2) ?></td>
                                    <td><?= $venta['metodo_pago'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5">No se encontraron ventas con los filtros.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="report-actions">
                <button class="action-btn export" onclick="exportar('excel')"><i class="fas fa-file-excel"></i> Exportar Excel</button>
                <button class="action-btn pdf" onclick="exportar('pdf')"><i class="fas fa-file-pdf"></i> Exportar PDF</button>
            </div>

        </div>
    </div>
</div>

<script>
function exportar(tipo) {
    const ventas = <?= $jsonVentas ?>;
    const endpoint = tipo === 'excel'
        ? 'http://127.0.0.1:5000/exportar/excel'
        : 'http://127.0.0.1:5000/exportar/pdf';

    fetch(endpoint, {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ ventas })
    })
    .then(res => res.blob())
    .then(blob => {
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = tipo === 'excel' ? "mis_ventas.xlsx" : "mis_ventas.pdf";
        document.body.appendChild(a);
        a.click();
        a.remove();
    });
}
</script>

</body>
</html>
