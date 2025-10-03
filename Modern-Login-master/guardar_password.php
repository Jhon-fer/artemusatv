<?php
require 'conexion.php';

$correo = $_POST['correo'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Actualizar password y activar usuario
$sql = "UPDATE usuarios SET password=?, estado=1, codigo_verificacion=NULL WHERE correo=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $password, $correo);

if ($stmt->execute()) {
    echo "✅ Cuenta activada, ya puedes iniciar sesión.";
    echo '<a href="index.php">Ir al login</a>';
} else {
    echo "Error al guardar la contraseña.";
}
?>
