<?php
$host = "localhost";
$dbname = "usuarios_db";
$user = "root";  // tu usuario de MySQL
$pass = "";      // tu contraseña de MySQL

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
