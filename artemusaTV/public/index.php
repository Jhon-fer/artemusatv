<?php
// Siempre redirige al visitante
header("Location: ../Recursos/visitante/index.php");
exit();
?>  

<?php
require_once '../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->login();
