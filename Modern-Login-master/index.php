<?php
session_start();
include("conexion.php"); // archivo de conexión a BD

// --- REGISTRO ---
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!empty($name) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            echo "<script>alert('✅ Registro exitoso, ahora puede iniciar sesión');</script>";
        } else {
            echo "<script>alert('❌ Error: el correo ya está registrado');</script>";
        }
        $stmt->close();
    }
}

// --- LOGIN ---
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, nombre, password FROM usuarios WHERE email=? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nombre, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['usuario'] = $nombre;
            header("Location: panel.php");
            exit;
        } else {
            echo "<script>alert('⚠️ Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('⚠️ El correo no existe');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="ixon.jpg">
    <link rel="stylesheet" href="style.css">
    <title>Login | ArtemusaTV</title>
</head>

<body>

    <div class="container" id="container">
        <!-- FORMULARIO DE REGISTRO -->
        <div class="form-container sign-up">
            <form method="POST" action="procesar_registro.php">
                <h1>CREAR CUENTA</h1>
                <input type="text" name="name" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Email" required>
                <button type="submit" name="register">REGISTRARSE</button>
            </form>
        </div>

        <!-- FORMULARIO DE LOGIN -->
        <div class="form-container sign-in">
            <form method="POST" action="">
                <h1>INICIAR SESIÓN</h1>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <a href="#">¿Olvidó su contraseña?</a>
                <button type="submit" name="login">INICIAR SESIÓN</button>
            </form>
        </div>

        <!-- PANEL TOGGLE -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>VUELVA AL INICIO DE SESIÓN</h1>
                    <p>Inicie sesión para descubrir la señal abierta de Puno para el mundo</p>
                    <button class="hidden" id="login">INICIAR SESIÓN</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>BIENVENIDO A ARTEMUSATV</h1>
                    <p>Regístrese para iniciar sesión y no perderse las últimas noticias de Puno para el mundo</p>
                    <button class="hidden" id="register">REGISTRARSE</button>
                </div>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
