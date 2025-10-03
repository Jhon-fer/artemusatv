<?php
session_start();
require_once __DIR__ . "/../../../config/database.php"; // Ajusta la ruta

// ⚠️ Verificar si el usuario pasó la validación del código
if (!isset($_SESSION['codigo_valido']) || $_SESSION['codigo_valido'] !== true) {
    echo "<script>alert('⚠️ Primero debe verificar su código'); window.location.href='contrasenaOlvidada.php';</script>";
    exit;
}

// ⚠️ También validamos que haya un correo en sesión
if (!isset($_SESSION['email_recuperar'])) {
    echo "<script>alert('⚠️ No se encontró un correo válido en la sesión'); window.location.href='contrasenaOlvidada.php';</script>";
    exit;
}

$email = $_SESSION['email_recuperar']; // ✅ CORRECTO

if (isset($_POST['cambiar'])) {
    $password = trim($_POST['password']);
    $password_confirm = trim($_POST['password_confirm']);

    if (empty($password) || empty($password_confirm)) {
        echo "<script>alert('⚠️ Llene todos los campos'); window.history.back();</script>";
        exit;
    }

    if ($password !== $password_confirm) {
        echo "<script>alert('❌ Las contraseñas no coinciden'); window.history.back();</script>";
        exit;
    }

    // ✅ Encriptar contraseña
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET password = :password WHERE email = :email");
        $stmt->execute([
            ':password' => $passwordHash,
            ':email' => $email
        ]);

        // ✅ Limpiar variables de sesión para seguridad
        unset($_SESSION['codigo'], $_SESSION['codigo_expira'], $_SESSION['codigo_valido'], $_SESSION['email_recuperar']);

        echo "<script>alert('✅ Contraseña actualizada correctamente'); window.location.href='../login.php';</script>";
        exit;
    } catch (Exception $e) {
        echo "<script>alert('❌ Error al actualizar la contraseña'); window.history.back();</script>";
        exit;
    }
}
?>
