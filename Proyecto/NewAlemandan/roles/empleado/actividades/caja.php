<?php
require_once("../../../includes/db.php");
session_start();

$fecha_actual = date("d/m/Y");

// Recuperar el nombre del cajero desde la sesión
$cajero = $_SESSION['usuario'] ?? 'Cajero Desconocido';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if ($data && isset($data['accion']) && $data['accion'] === 'finalizar') {
        $productos = $data['productos'];
        $metodo_pago = $data['metodo_pago'] ?? 'efectivo';

        try {
            $conexion->beginTransaction();

            // Verificar stock disponible
            foreach ($productos as $producto) {
                $stmtStock = $conexion->prepare("SELECT stock FROM productos WHERE id = ?");
                $stmtStock->execute([$producto['id']]);
                $stockDisponible = $stmtStock->fetchColumn();

                if ($stockDisponible === false || $stockDisponible < $producto['cantidad']) {
                    $conexion->rollBack();
                    echo json_encode([
                        "status" => "error",
                        "message" => "Stock insuficiente para el producto: " . htmlspecialchars($producto['nombre'])
                    ]);
                    exit;
                }
            }

            // Calcular total de la venta
            $totalVenta = 0;
            foreach ($productos as $producto) {
                $totalVenta += $producto['precio'] * $producto['cantidad'];
            }

            // Registrar venta
            $stmtVenta = $conexion->prepare("INSERT INTO ventas (fecha, productos, total, metodo_pago, cajero) VALUES (NOW(), ?, ?, ?, ?)");
            $stmtVenta->execute([json_encode($productos), $totalVenta, $metodo_pago, $cajero]);

            // Actualizar stock
            $stmtActualizarStock = $conexion->prepare("UPDATE productos SET stock = stock - ? WHERE id = ?");
            foreach ($productos as $producto) {
                $stmtActualizarStock->execute([$producto['cantidad'], $producto['id']]);
            }

            $conexion->commit();
            echo json_encode(["status" => "ok"]);
        } catch (Exception $e) {
            $conexion->rollBack();
            echo json_encode(["status" => "error", "message" => $e->getMessage()]);
        }

        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alemandan - Módulo de Caja</title>
    <link rel="stylesheet" href="/assets/css/dashboards.css">
    <link rel="stylesheet" href="/assets/css/caja.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <img src="/assets/img/Alogo2.png" alt="Logo Alemandan" width="180px">
        </div>
        <div class="nav-menu">
            <a href="/roles/empleado/dashboard_emp.php" class="nav-item">
                <i class="fas fa-home"></i><span>Inicio</span>
            </a>

            <a href="/roles/empleado/actividades/caja.php" class="nav-item active">
                <i class="fas fa-cash-register"></i><span>Caja</span>
            </a>

            <a href="/roles/empleado/actividades/mis_ventas.php" class="nav-item">
                <i class="fas fa-chart-bar"></i><span>Mis Ventas</span>
            </a>

            <a href="/main pages/index.php" class="nav-item">
                <i class="fas fa-sign-out-alt"></i><span>Cerrar sesión</span>
            </a>
        </div>
    </div>

    <div class="main-content">

        <div class="caja-container">
            <div class="control-panel">
                <button id="iniciarCompraBtn" class="caja-btn primary">
                    <i class="fas fa-play"></i> Iniciar Nueva Compra
                </button>
                <div class="scanner-section">
                    <h3><i class="fas fa-barcode"></i> Escanear Producto</h3>
                    <input type="text" id="codigoProducto" placeholder="Código o nombre del producto">
                    <button id="escanearBtn" class="caja-btn secondary">
                        <i class="fas fa-search"></i> Buscar Manualmente
                    </button>
                </div>
                <div class="payment-section">
                    <h3><i class="fas fa-money-bill-wave"></i> Total a Pagar</h3>
                    <div class="total-amount" id="totalPagar">$0</div>
                    <div class="payment-methods">
                        <button class="payment-btn" data-method="efectivo"><i class="fas fa-money-bill"></i> Efectivo</button>
                        <button class="payment-btn" data-method="tarjeta"><i class="fas fa-credit-card"></i> Tarjeta</button>
                        <button class="payment-btn" data-method="transferencia"><i class="fas fa-exchange-alt"></i> Transferencia</button>
                    </div>
                    <button id="finalizarCompraBtn" class="caja-btn success" disabled>
                        <i class="fas fa-check-circle"></i> Finalizar Compra
                    </button>
                    <div id="mensajeCompra" style="margin-top: 10px;"></div>
                </div>
            </div>

            <div class="product-list-panel">
                <h3><i class="fas fa-receipt"></i> Ticket de Venta</h3>
                <div class="ticket-header">
                    <div class="ticket-info">
                        <div>Fecha: <span id="fechaActual"><?= $fecha_actual ?></span></div>
                        <div>Cajero: <?= htmlspecialchars($cajero) ?></div>
                        <div>N° Venta: <span id="numeroVenta">0001</span></div>
                    </div>
                </div>
                <div class="product-list-container">
                    <table class="product-table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cant.</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="listaProductos">
                            <tr class="empty-message">
                                <td colspan="5"><i class="fas fa-shopping-cart"></i><p>No hay productos agregados</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="ticket-summary">
                    <div class="summary-row"><span>Subtotal:</span><span id="subtotal">$0</span></div>
                    <div class="summary-row"><span>IVA (19%):</span><span id="iva">$0</span></div>
                    <div class="summary-row total"><span>Total:</span><span id="total">$0</span></div>
                </div>
            </div>
        </div>
    </div>

    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <h3>Buscar Producto</h3>
            <input type="text" id="buscarProducto" placeholder="Nombre o código del producto">
            <div id="resultadosBusqueda" class="search-results"></div>
        </div>
    </div>

    <script src="/assets/js/caja.js"></script>
</body>
</html>
