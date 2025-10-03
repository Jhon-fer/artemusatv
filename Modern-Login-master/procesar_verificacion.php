<?php
require 'conexion.php';

$correo = $_POST['correo'];
$codigo = $_POST['codigo'];

$sql = "SELECT * FROM usuarios WHERE correo=? AND codigo_verificacion=? AND estado=0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $codigo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Código válido → pedir contraseña
    echo '<form action="guardar_password.php" method="POST">
            <input type="hidden" name="correo" value="'.$correo.'">
            <label>Nueva contraseña:</label>
            <input type="password" name="password" required>
            <button type="submit">Guardar</button>
          </form>';
} else {
    echo "Código incorrecto o ya verificado.";
}
?>
