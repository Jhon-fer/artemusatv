<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel | ArtemusaTV</title>
</head>
<body>
    <h1>Bienvenido <?php echo $_SESSION['usuario']; ?> 🎉</h1>
    <a href="salir.php">Cerrar sesión</a>
</body>
</html>
