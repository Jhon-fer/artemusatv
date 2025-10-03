<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido</title>
</head>
<body>
    <h2>Bienvenido <?php echo $_SESSION['username']; ?></h2>
    <a href="loguin/logout.php">Cerrar sesión</a>
</body>
</html>
