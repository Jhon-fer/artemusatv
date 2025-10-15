<?php
session_start();
session_unset();
session_destroy();

// Redirige al login
header("Location: ../app/views/login.php"); // desde public/ sube a public_html/ y entra a app/views/login.php
exit();
