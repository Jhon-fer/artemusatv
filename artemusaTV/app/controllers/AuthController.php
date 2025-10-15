<?php 
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        session_start();

        // Si ya hay sesión, redirige según rol
        if (isset($_SESSION['usuario']) && isset($_SESSION['rol'])) {
            switch ($_SESSION['rol']) {
                case 'viewer':
                    header('Location: /Recursos/viewer/index.php');
                    break;
                case 'trabajador':
                    header('Location: /Recursos/trabajador/index.php');
                    break;
                default:
                    header('Location: /Recursos/index.php');
            }
            exit();
        }

        // Procesar formulario de login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user    = new User();
            $usuario = $_POST['usuario'] ?? '';
            $clave   = $_POST['clave'] ?? '';

            $resultado = $user->validar($usuario, $clave);

            if ($resultado) {
                $_SESSION['usuario'] = $resultado['usuario'];
                $_SESSION['rol']     = $resultado['rol'];

                // Redirige según rol
                switch ($_SESSION['rol']) {
                    case 'viewer':
                        header('Location: /Recursos/viewer/index.php');
                        break;
                    case 'trabajador':
                        header('Location: /Recursos/trabajador/index.php');
                        break;
                    default:
                        header('Location: /Recursos/index.php');
                }
                exit();
            } else {
                $error = "Usuario o contraseña incorrectos.";
            }
        }

        // Mostrar login (con o sin error)
        include __DIR__ . '/../views/login.php';
    }
}
