<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        session_start();

        // Si ya existe sesión, redirige según rol
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
            if ($_SESSION['rol'] === 'viewer') {
                header('Location: ../Recursos/viewer/index.php');
                exit();
            } elseif ($_SESSION['rol'] === 'trabajador') {
                header('Location: ../Recursos/trabajador/index.php');
                exit();
            } else {
                header('Location: ../Recursos/index.php');
                exit();
            }
        }

        // Si viene del formulario de login
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user = new User();
            $usuario = $_POST['usuario'];
            $clave   = $_POST['clave'];

            $resultado = $user->validar($usuario, $clave);

            if ($resultado) {
                $_SESSION['usuario'] = $resultado['usuario'];
                $_SESSION['rol']     = $resultado['rol']; // 🔹 Guardamos rol

                // Redirige según rol
                if ($_SESSION['rol'] === 'viewer') {
                    header('Location: ../Recursos/viewer/index.php');
                } elseif ($_SESSION['rol'] === 'trabajador') {
                    header('Location: ../Recursos/trabajador/index.php');
                } else {
                    header('Location: ../Recursos/index.php');
                }
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
                include '../app/views/login.php';
            }
        } else {
            // Si entra sin sesión → muestra login (no redirige aún)
            include '../app/views/login.php';
        }
    }
}
