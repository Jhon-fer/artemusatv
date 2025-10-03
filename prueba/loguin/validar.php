<?php
session_start();
require __DIR__ . '/../config/db.php';

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // para el ejemplo simple

    $sql = "SELECT * FROM usuarios WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $_SESSION['username'] = $username;
        header("Location: ../bienvenida.php");
    } else {
        header("Location: login.php?error=Usuario o contraseña incorrectos");
    }
} else {
    header("Location: login.php");
}
?>
