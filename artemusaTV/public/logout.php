<?php
session_start();
session_unset();  // limpia variables de sesión
session_destroy(); // destruye la sesión

// Redirigir al login general
header("Location: /Practicas/artemusaTV/app/views/login.php");
exit;
