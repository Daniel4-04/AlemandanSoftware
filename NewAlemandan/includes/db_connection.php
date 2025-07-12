<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "rol"; // Tu base de datos

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}
?>
