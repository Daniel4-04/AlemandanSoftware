<?php
require_once("db.php"); // Ya está bien así

if (isset($_GET['query'])) {
    $query = trim($_GET['query']);

    $stmt = $conexion->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR id = ?");
    $stmt->execute(["%$query%", intval($query)]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($productos);
}
?>
