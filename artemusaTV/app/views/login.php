<?php
session_start();
require_once __DIR__ . "/../../config/database.php"; // aquí ya tienes $pdo

// --- REGISTRO ---
if (isset($_POST['register'])) {
    $name             = trim($_POST['name']);
    $email            = trim($_POST['email']);
    $password         = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    if (!empty($name) && !empty($email) && !empty($password)) {
        
        // Verificar confirmación
        if ($password !== $password_confirm) {
            echo "<script>alert('⚠️ Las contraseñas no coinciden');</script>";
            exit;
        }

        // Hashear contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Rol por defecto
        $rol = "viewer";

        try {
            $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol, creado_en) 
                                   VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $email, $hashedPassword, $rol]);

            echo "<script>
                alert('✅ Registro exitoso, ahora puede iniciar sesión');
                window.location.href='login.php';
            </script>";
            exit;
        } catch (PDOException $e) {
            echo "<script>alert('❌ Error: el correo ya está registrado');</script>";
        }
    } else {
        echo "<script>alert('⚠️ Todos los campos son obligatorios');</script>";
    }
}

// --- LOGIN ---
if (isset($_POST['login'])) {
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT id, nombre, password, rol FROM usuarios WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // ✅ Verificar hash de contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['usuario']    = $user['nombre'];
            $_SESSION['rol']        = $user['rol'];

            // Redirigir según el rol
            if ($user['rol'] === 'trabajador') {
                header("Location: /Practicas/artemusaTV/Recursos/trabajador/index.php");
            } elseif ($user['rol'] === 'viewer') {
                header("Location: /Practicas/artemusaTV/Recursos/viewer/index.php");
            } else {
                header("Location: /Practicas/artemusaTV/panel.php");
            }
            exit;
        } else {
            echo "<script>alert('⚠️ Contraseña incorrecta');</script>";
        }
    } else {
        echo "<script>alert('⚠️ El correo no existe');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="img/ixon.jpg">
    <link rel="stylesheet" href="style/stylel.css">
    <title>Login | ArtemusaTV</title>
</head>

<body>

    <div class="container" id="container">
        <!-- FORMULARIO DE REGISTRO -->
        <div class="form-container sign-up">
            <form method="POST" action="recuperar/enviar_codigo.php">
                <h1>CREAR CUENTA</h1>
                <input type="text" name="name" placeholder="Nombre" required>
                <input type="email" name="email" placeholder="Email" required>

                <!-- Campo de contraseña con botón de ojo -->
                <div style="position: relative; width: 100%; margin-bottom:10px;">
                    <input type="password" id="password_register" name="password" placeholder="Contraseña" required 
                        style="width:100%; padding-right:40px;" oninput="checkStrength(this.value)">
                    <span onclick="togglePassword('password_register')" 
                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; user-select:none; font-size:18px;">
                        👁️
                    </span>
                </div>

                <!-- Barra de seguridad -->
                <div id="strength-bar" style="width:100%; height:8px; border-radius:5px; background:#ddd; margin-bottom:15px;">
                    <div id="strength-fill" style="height:100%; width:0%; border-radius:5px; transition:width 0.3s;"></div>
                </div>
                <p id="strength-text" style="font-size:14px; margin:0 0 10px 0; color:#555;"></p>

                <!-- Confirmar contraseña con botón de ojo -->
                <div style="position: relative; width: 100%;">
                    <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirmar Contraseña" required style="width:100%; padding-right:40px;">
                    <span onclick="togglePassword('password_confirm')" 
                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; user-select:none; font-size:18px;">
                        👁️
                    </span>
                </div>

                <button type="submit" name="register">REGISTRARSE</button>
            </form>
        </div>

        <!-- FORMULARIO DE LOGIN -->
        <div class="form-container sign-in">
            <form method="POST" action="">
                <h1>INICIAR SESIÓN</h1>
                <input type="email" name="email" placeholder="Email" required>

                <!-- Campo de contraseña con botón de ojo -->
                <div style="position: relative; width: 100%;">
                    <input type="password" id="password_login" name="password" placeholder="Contraseña" required style="width:100%; padding-right:40px;">
                    <span onclick="togglePassword('password_login')" 
                        style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer; user-select:none; font-size:18px;">
                        👁️
                    </span>
                </div>

                <a href="recuperar/contrasenaOlvidada.php">¿Olvidó su contraseña?</a>
                <a href="/Practicas/artemusaTV/Recursos/visitante/index.php">Seguir como visitante</a>
                <button type="submit" name="login">INICIAR SESIÓN</button>
            </form>
        </div>

        <!-- Enlace debajo del login -->
        <p class="toggle-link">
        ¿No tienes cuenta? <a href="#" id="mostrarRegistro">Regístrate aquí</a>
        </p>

        <!-- Enlace debajo del registro -->
        <p class="toggle-link">
        ¿Ya tienes cuenta? <a href="#" id="mostrarLogin">Inicia sesión aquí</a>
        </p>

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

    <script src="js/script.js"></script>
    <script src="js/validar.js"></script>
    <script>
    function togglePassword(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }
    </script>
    <script>
    document.getElementById("mostrarRegistro").addEventListener("click", e => {
        e.preventDefault();
        document.querySelector(".container").classList.add("show-register");
    });

    document.getElementById("mostrarLogin").addEventListener("click", e => {
        e.preventDefault();
        document.querySelector(".container").classList.remove("show-register");
    });
    </script>
</body>
</html>
