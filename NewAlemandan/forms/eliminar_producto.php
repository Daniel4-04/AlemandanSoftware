<?php
require_once("../includes/db.php");

if (!isset($_GET['id'])) {
    header("Location: /roles/administrador/actividades/inventario.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conexion->prepare("DELETE FROM productos WHERE id = ?");
$stmt->execute([$id]);

header("Location: /roles/administrador/actividades/inventario.php");
exit;
?>
