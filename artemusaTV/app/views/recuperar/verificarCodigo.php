<?php
session_start();

if (isset($_POST['verificar'])) {
    $codigoIngresado = trim($_POST['codigo']);

    if (empty($codigoIngresado)) {
        echo "<script>alert('⚠️ Ingrese el código recibido'); window.history.back();</script>";
        exit;
    }

    if (!isset($_SESSION['codigo']) || time() > $_SESSION['codigo_expira']) {
        echo "<script>alert('❌ El código ha expirado'); window.history.back();</script>";
        exit;
    }

    if ($codigoIngresado == $_SESSION['codigo']) {
        $_SESSION['codigo_valido'] = true;
        header("Location: contrasenaOlvidada.php");
        exit;
    } else {
        echo "<script>alert('❌ Código incorrecto'); window.history.back();</script>";
        exit;
    }
} else {
    // Si alguien abre directamente el archivo sin POST
    header("Location: contrasenaOlvidada.php");
    exit;
}
