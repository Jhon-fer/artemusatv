<?php
session_start();
require_once __DIR__ . "/../../../config/database.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="icon" href="../img/ixon.jpg">
    <link rel="stylesheet" href="../style/stylel.css">
    <title>Recuperar Contraseña | ArtemusaTV</title>
</head>

<body>
    <div class="container" id="container">
        
        <!-- FORMULARIO: ENVIAR Y VERIFICAR CÓDIGO -->
        <div class="form-container sign-in">
            <form id="formRecuperar" method="POST">
                <h1>Recuperar acceso</h1>
                <a href="../login.php">← Volver al login</a>

                <!-- Correo -->
                <input type="email" name="email" placeholder="Correo electrónico" required>
                
                <!-- Botón para enviar código -->
                <button type="submit" name="enviar" formaction="enviarCodigo.php">ENVIAR CÓDIGO</button>

                <!-- Campo para escribir el código -->
                <input type="text" name="codigo" placeholder="Código de verificación">
                <!-- El botón de verificar está en el toggle -->
            </form>
        </div>

        <!-- FORMULARIO 2: Nueva contraseña -->
        <div class="form-container sign-up">
            <form method="POST" action="nuevaContrasena.php">
                <h1>Nueva Contraseña</h1>
                <p>Ingrese y confirme su nueva contraseña</p>
                <input type="password" name="password" placeholder="Nueva contraseña" required>
                <input type="password" name="password_confirm" placeholder="Confirmar contraseña" required>
                <button type="submit" name="cambiar">CAMBIAR</button>
            </form>
        </div>

        <!-- PANEL TOGGLE -->
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>¿Ya verificó el código?</h1>
                    <p>Si el código es válido puede cambiar su contraseña</p>
                    <button class="hidden" id="irCambiar">Cambiar contraseña</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>¿Olvidó su contraseña?</h1>
                    <p>Ingrese su correo y código para continuar</p>
                    <!-- Este botón dispara el envío del formulario -->
                    <button type="button" id="irVerificar">VERIFICAR</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById("container");
        const btnCambiar = document.getElementById("irCambiar");
        const btnVerificar = document.getElementById("irVerificar");
        const form = document.getElementById("formRecuperar");

        // Botón para ir directo al panel de cambiar contraseña
        btnCambiar.addEventListener("click", () => container.classList.add("active"));

        // Botón para verificar código
        btnVerificar.addEventListener("click", () => {
            const inputHidden = document.createElement("input");
            inputHidden.type = "hidden";
            inputHidden.name = "verificar";
            inputHidden.value = "1";
            form.appendChild(inputHidden);

            // Enviar el formulario a verificarCodigo.php
            form.action = "verificarCodigo.php";
            form.submit();
        });

        // Si ya se verificó el código, abrir panel de nueva contraseña
        <?php if (isset($_SESSION['codigo_valido']) && $_SESSION['codigo_valido'] === true): ?>
            document.addEventListener("DOMContentLoaded", () => {
                container.classList.add("active");
            });
        <?php endif; ?>
    </script>
</body>
</html>
