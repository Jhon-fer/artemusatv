<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Iniciar Sesión</h2>
    <form action="validar.php" method="POST">
        Usuario: <input type="text" name="username" required><br><br>
        Contraseña: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <?php
    if(isset($_GET['error'])){
        echo "<p style='color:red'>".$_GET['error']."</p>";
    }
    ?>
</body>
</html>
