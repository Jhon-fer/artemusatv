<?php
require 'conexion.php';
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    // Generar un código de 6 dígitos
    $codigo = rand(100000, 999999);

    // Insertar usuario en la BD
    $sql = "INSERT INTO usuarios (nombre, correo, codigo_verificacion, estado) 
            VALUES (?, ?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nombre, $correo, $codigo);

    if ($stmt->execute()) {
        // Enviar correo con el código
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = "smtp.gmail.com";
            $mail->SMTPAuth   = true;
            $mail->Username   = "tu_correo@gmail.com";
            $mail->Password   = "tu_clave_app";
            $mail->SMTPSecure = "tls";
            $mail->Port       = 587;

            $mail->setFrom("tu_correo@gmail.com", "Soporte Panel");
            $mail->addAddress($correo);

            $mail->isHTML(true);
            $mail->Subject = "Código de verificación";
            $mail->Body    = "<p>Hola <b>$nombre</b>,</p>
                              <p>Tu código de verificación es: <b>$codigo</b></p>
                              <p>Ingresa este código en la página de verificación.</p>";

            $mail->send();

            header("Location: verificar.php?correo=" . urlencode($correo));
            exit;

        } catch (Exception $e) {
            echo "Error al enviar correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error en registro.";
    }
}
?>
