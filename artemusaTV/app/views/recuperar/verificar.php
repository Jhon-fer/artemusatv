<?php
session_start();
require __DIR__ . "/../../../config/database.php";

if (isset($_POST['verificar'])) {
    $codigo = trim($_POST['codigo']);

    if (isset($_SESSION['codigo'], $_SESSION['codigo_expira'], $_SESSION['registro_temp'])) {
        if (time() > $_SESSION['codigo_expira']) {
            echo "<script>alert('⚠️ El código ha expirado'); window.location.href='../login.php';</script>";
            exit;
        }

        if ($codigo == $_SESSION['codigo']) {
            $name     = $_SESSION['registro_temp']['name'];
            $email    = $_SESSION['registro_temp']['email'];
            $password = $_SESSION['registro_temp']['password'];
            $rol      = "viewer";

            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol, creado_en) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $password, $rol]);

            unset($_SESSION['registro_temp'], $_SESSION['codigo'], $_SESSION['codigo_expira']);

            echo "<script>
                alert('✅ Registro completado, ahora puede iniciar sesión');
                window.location.href='../login.php';
            </script>";
            exit;
        } else {
            echo "<script>alert('⚠️ Código incorrecto');</script>";
        }
    } else {
        echo "<script>alert('⚠️ No hay un registro en proceso'); window.location.href='../login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/verificacion.css">
    <link rel="icon" href="../img/ixon.jpg">
    <title>Verificación | ArtemusaTV</title>
</head>
<body>
    <div class="container">
        <!-- LADO IZQUIERDO: Formulario -->
        <div class="form-container">
            <h1>Verificar código</h1>
            <form method="POST">
                <input type="text" name="codigo" placeholder="Código de verificación" required>
                <button type="submit" name="verificar">Confirmar</button>
                <a href="../login.php" class="cancel-link">Cancelar</a>
            </form>
        </div>

        <!-- LADO DERECHO: Panel rojo -->
        <div class="toggle-container">
            <h1>Verificación</h1>
            <div class="alert-message">
                📧 Le hemos enviado un <strong>código de verificación</strong> a su correo electrónico.<br>
                Revíselo e ingréselo en el formulario.<br>
                Este código expira en <strong>5 minutos</strong>.
            </div>
            <p>Inicie sesión para descubrir la señal abierta de Puno para el mundo</p>
        </div>
    </div>
</body>
</html>
