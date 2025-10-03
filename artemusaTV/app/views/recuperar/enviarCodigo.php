<?php
session_start();
require_once __DIR__ . "/../../../config/database.php";
require __DIR__ . "/../../../vendor/autoload.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['enviar'])) {
    $email = trim($_POST['email']);

    if (empty($email)) {
        echo "<script>alert('⚠️ Ingrese su correo'); window.location.href='../views/recuperar/contrasenaOlvidada.php';</script>";
        exit;
    }

    // Generar código
    $codigo = rand(100000, 999999);
    $_SESSION['codigo'] = $codigo;
    $_SESSION['codigo_expira'] = time() + 300;
    $_SESSION['email_recuperar'] = $email;

    // Configurar PHPMailer
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = "smtp.gmail.com";
        $mail->SMTPAuth   = true;
        $mail->Username   = "jfer.gquispe.dev@gmail.com"; 
        $mail->Password   = "larv kgvm vdbp voxe";        
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->CharSet  = "UTF-8";
        $mail->Encoding = "base64";

        $mail->setFrom("verificacion467@gmail.com", "ArtemusaTV - Recuperación");
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = "Código de verificación - ArtemusaTV";
        $mail->Body = '
        <!DOCTYPE html>
        <html lang="es">
        <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; background-color: #d32f2f; color: #f1f1f1; margin:0; padding:20px; }
            .container { max-width: 520px; margin: auto; background: #d32f2f; border-radius: 8px; padding: 20px; border: 3px solid #000; }
            .header { text-align: center; margin-bottom: 20px; }
            .header img { max-width: 120px; }
            h1 { color: #000; font-size: 22px; text-align: center; margin-top: 10px; }
            p { line-height: 1.6; font-size: 14px; color: #f1f1f1; }
            .code-box { background: #fff; padding: 18px; text-align: center; font-size: 28px; font-weight: bold; color: #000; border-radius: 6px; margin: 20px 0; letter-spacing: 3px; }
            .section { margin-top: 20px; }
            .section h3 { color: #fff; font-size: 16px; margin-bottom: 8px; }
            .section p { color: #f1f1f1; font-size: 13px; }
            .section a { color: #000; font-weight: bold; text-decoration: underline; }
            .footer { font-size: 11px; color: #f1f1f1; margin-top: 30px; text-align: center; border-top: 2px solid #000; padding-top: 15px; }
        </style>
        </head>
        <body>
        <div class="container">
            <div class="header">
                <img src="cid:logo_artemusa" alt="ArtemusaTV Logo">
                <h1>ArtemusaTV - Código para Cambiar de Contraseña</h1>
            </div>

            <p>Detectamos un intento de inicio de sesión desde un nuevo dispositivo.<br>
            Aquí tienes tu código de verificación para continuar:</p>
            
            <div class="code-box">'.$codigo.'</div>
            
            <div class="section">
                <h3>⚠️ Si no has sido tú</h3>
                <p>Te enviamos este correo porque alguien intentó acceder a tu cuenta de ArtemusaTV.<br>
                Si no fuiste tú, te recomendamos 
                <a href="http://localhost/Practicas/artemusaTV/app/views/recuperar/contrasenaOlvidada.php">
                restablecer tu contraseña</a> de inmediato.</p>
            </div>
            
            <div class="section">
                <h3>📍 ¿No reconoces esta ubicación?</h3>
                <p>Si no reconoces el inicio de sesión, es posible que otra persona esté intentando acceder.<br>
                Revisa la seguridad de tu cuenta antes de continuar.</p>
            </div>
            
            <div class="footer">
                <p>Este mensaje se generó automáticamente. No respondas a este correo.</p>
                <p>&copy; '.date("Y").' ArtemusaTV</p>
            </div>
        </div>
        </body>
        </html>';

        $mail->AddEmbeddedImage(__DIR__ . "/../img/ixon.jpg", "logo_artemusa", "logo.png");

        $mail->send();

        // ✅ Redirigir con mensaje
        $_SESSION['mensaje'] = "📧 Código enviado a su correo";
        header("Location: contrasenaOlvidada.php");
        exit;
    } catch (Exception $e) {
        $_SESSION['mensaje'] = "❌ Error al enviar correo: {$mail->ErrorInfo}";
        header("Location: contrasenaOlvidada.php");
        exit;
    }
}
