<?php
$servidor = "localhost";
$usuario = "root";
$clave = "";
$basedatos = "login";

$conn = new mysqli($servidor, $usuario, $clave, $basedatos);

if ($conn->connect_error) {
    die("❌ Error en la conexión: " . $conn->connect_error);
}
?>
