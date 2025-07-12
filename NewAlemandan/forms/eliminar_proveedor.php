<?php
require_once("../includes/db.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $conexion->prepare("DELETE FROM proveedores WHERE id = ?");
    $stmt->execute([$id]);

    // Redirige al panel de proveedores con la ruta correcta
    header("Location: /roles/administrador/actividades/proveedores.php");
    exit;
}

// En caso de que no haya ID, redirige también al panel
header("Location: /roles/administrador/actividades/proveedores.php");
exit;
?>
