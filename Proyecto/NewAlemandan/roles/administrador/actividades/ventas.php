<?php
require_once("../../../includes/db.php");

$filtroProducto = $_GET['producto'] ?? '';
$filtroCajero = $_GET['cajero'] ?? '';
$filtroMetodo = $_GET['metodo_pago'] ?? '';
$fechaDesde = $_GET['fecha_desde'] ?? '';
$fechaHasta = $_GET['fecha_hasta'] ?? '';

// Query con filtros
$sql = "SELECT * FROM ventas WHERE 1=1";
$params = [];

if ($filtroProducto) {
    $sql .= " AND productos LIKE :producto";
    $params[':producto'] = "%$filtroProducto%";
}
if ($filtroCajero) {
    $sql .= " AND cajero LIKE :cajero";
    $params[':cajero'] = "%$filtroCajero%";
}
if ($filtroMetodo) {
    $sql .= " AND metodo_pago = :metodo_pago";
    $params[':metodo_pago'] = $filtroMetodo;
}
if ($fechaDesde && $fechaHasta) {
    $sql .= " AND fecha BETWEEN :desde AND :hasta";
    $params[':desde'] = $fechaDesde;
    $params[':hasta'] = $fechaHasta;
}

$sql .= " ORDER BY fecha DESC";
$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// JSON codificado para exportar
$jsonVentas = json_encode($ventas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Ventas - Alemandan CRM</title>
    <link rel="stylesheet" href="/assets/css/ventas.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<div class="sidebar">
    <div class="logo"><img src="/assets/img/Alogo2.png" alt="Logo Alemandan" width="180"></div>
    <div class="nav-menu">
        <a href="/roles/administrador/dashboard_admin.php" class="nav-item"><i class="fas fa-home"></i>Inicio</a>
        <a href="/roles/administrador/actividades/inventario.php" class="nav-item"><i class="fas fa-wallet"></i>Inventario</a>
        <a href="/roles/administrador/actividades/empleados.php" class="nav-item"><i class="fas fa-sliders-h"></i>Empleados</a>
        <a href="/roles/administrador/actividades/proveedores.php" class="nav-item"><i class="fas fa-comment-dots"></i>Proveedores</a>
        <a href="/roles/administrador/actividades/ventas.php" class="nav-item active"><i class="fas fa-chart-line"></i>Ventas</a>
        <a href="/main pages/index.php" class="nav-item"><i class="fas fa-life-ring"></i>Cerrar sesión</a>
    </div>
</div>

<div class="main-content">
    <div class="dashboard-container">
        <div class="dashboard-main">
            
            <!-- Filtros -->
            <form method="GET" class="filtro-form">
                <div class="filtro-campo">
                    <label for="producto">Producto</label>
                    <input type="text" name="producto" id="producto" placeholder="Ej: Manzana" value="<?= htmlspecialchars($filtroProducto) ?>">
                </div>

                <div class="filtro-campo">
                    <label for="cajero">Cajero</label>
                    <input type="text" name="cajero" id="cajero" placeholder="Ej: Laura" value="<?= htmlspecialchars($filtroCajero) ?>">
                </div>

                <div class="filtro-campo">
                    <label for="metodo_pago">Método de Pago</label>
                    <select name="metodo_pago" id="metodo_pago">
                        <option value="">Todos</option>
                        <option value="efectivo" <?= $filtroMetodo === 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                        <option value="transferencia" <?= $filtroMetodo === 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                        <option value="tarjeta" <?= $filtroMetodo === 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
                    </select>
                </div>

                <div class="filtro-campo">
                    <label for="fecha_desde">Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" value="<?= htmlspecialchars($fechaDesde) ?>">
                </div>

                <div class="filtro-campo">
                    <label for="fecha_hasta">Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" value="<?= htmlspecialchars($fechaHasta) ?>">
                </div>

                <div class="filtro-campo">
                    <label>&nbsp;</label>
                    <button type="submit"><i class="fas fa-filter"></i> Aplicar Filtros</button>
                </div>
            </form>

            <!-- Tabla de ventas -->
            <div class="report-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Productos</th>
                            <th>Total</th>
                            <th>Método de Pago</th>
                            <th>Cajero</th>
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
                                                echo "🔹 " . $p['nombre'] . " x" . $p['cantidad'] . " - $" . number_format($p['precio'], 0, ',', '.') . "<br>";
                                            }
                                        } else {
                                            echo $venta['productos'];
                                        }
                                        ?>
                                    </td>
                                    <td>$<?= number_format($venta['total'], 2) ?></td>
                                    <td><?= $venta['metodo_pago'] ?></td>
                                    <td><?= $venta['cajero'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6">No se encontraron ventas con los filtros aplicados.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Botones de exportación -->
            <div class="report-actions">
                <button class="action-btn export" onclick="exportar('excel')"><i class="fas fa-file-export"></i> Exportar Excel</button>
                <button class="action-btn pdf" onclick="exportar('pdf')"><i class="fas fa-file-pdf"></i> Exportar PDF</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
function exportar(tipo) {
    const ventas = <?= $jsonVentas ?>;
    const endpoint = tipo === 'excel' ? 'http://127.0.0.1:5000/exportar/excel' : 'http://127.0.0.1:5000/exportar/pdf';

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
        a.download = tipo === 'excel' ? "reporte_ventas.xlsx" : "reporte_ventas.pdf";
        document.body.appendChild(a);
        a.click();
        a.remove();
    });
}
</script>

</body>
</html>
