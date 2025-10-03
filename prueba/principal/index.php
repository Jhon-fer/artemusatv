<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/ixon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>ARTEMUSA TV</title>
</head>
<style>
    /* --- estilos para el menú desplegable --- */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown a {
        text-decoration: none;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #fff;
        min-width: 180px;
        box-shadow: 0px 8px 16px rgba(0,0,0,0.2);
        padding: 10px 0;
        z-index: 1000;
    }

    .dropdown-content li {
        list-style: none;
    }

    .dropdown-content li a,
    .dropdown-content li strong {
        display: block;
        padding: 10px;
        color: #333;
        text-decoration: none;
    }

    .dropdown-content li a:hover {
        background-color: #f1f1f1;
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }
</style>
<body>
    <nav>
        <a class="logo">ARTEMUSA TV</a>
        <img src="img/baner.jpg" alt="iconA">
        <span class="menu-toggle">☰</span>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="#">Programas</a></li>
            <li><a href="pogramasN/index.php">Noticias</a></li>
            <li><a href="#">Servicio</a></li>
            <li><a href="#">Información</a></li>
            <li><a href="#">Contacto</a></li>

            <?php if (isset($_SESSION['usuario'])): ?>
                <li class="dropdown">
                    <a href="#">
                        <?= htmlspecialchars($_SESSION['usuario']['email']) ?> ▼
                    </a>
                    <ul class="dropdown-content">
                        <li><strong><?= htmlspecialchars($_SESSION['usuario']['nombre']) ?></strong></li>
                        <li><a href="../loguin/logout.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li><a href="loguin/login.php">Iniciar Sesión</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="main-container">
       <!-- Columna izquierda: Carrusel de noticias -->
        <div class="left-column">
            <h2>Noticias</h2>
            <ul class="news-carousel" id="news-carousel">
                <li>Últimas actualizaciones de Puno</li>
                <li>Evento cultural en la ciudad</li>
                <li>Deportes locales: campeonato regional</li>
                <li>Economía regional: novedades</li>
                <li>Educación: nuevo programa escolar</li>
            </ul>
            <a href="pogramas/index.html" class="more-news-link">Ver todas las noticias</a>
        </div>

        <!-- Columna central: Pantalla de transmisión -->
        <div class="center-column">
            <!-- Pantalla de transmisión -->
            <div class="live-screen">
                <iframe id="live-video" src="tu_fuente_vmix_o_ndi" frameborder="0" allowfullscreen></iframe>
            </div>

            <!-- Información dinámica de la transmisión debajo del video -->
            <div class="transmission-info">
                <h2 id="live-title">Transmisión en Vivo</h2>
                <p id="live-description">Actualmente se está transmitiendo el programa principal de ARTEMUSA TV.</p>
            </div>
        </div>

        <!-- Columna derecha: Cuadro adicional -->
        <div class="right-column">
            <h2>Información</h2>
            <div class="side-box">
                Aquí puedes colocar publicidad, estadísticas, o chat.
            </div>
        </div>
    </div>

   <!-- Pie de página -->
    <div class="footer">
        <div class="footer-column">
            <p>© 2025 ARTEMUSA TV<br>Todos los derechos reservados</p>
        </div>
        <div class="footer-column">
            <p>Contacto: <a href="mailto:contacto@artemusatv.pe">contacto@artemusatv.pe</a></p>
            <p>Tel: <a href="tel:123456789">123-456-789</a></p>
            <p>Ubicación: <a href="https://www.google.com/maps/place/Jr.+Cutimbo+285,+Puno,+Perú" target="_blank">Jr. Cutimbo Nro. 285, Barrio Chacarrilla Alta, Puno, Perú</a></p>
            <p>Horario: Lunes a Viernes 08:00 - 20:00</p>
        </div>
        <div class="footer-column">
            <h4>Síguenos</h4>
            <ul class="social-icons">
                <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="#" target="_blank"><i class="fab fa-twitter"></i> Twitter</a></li>
                <li><a href="#" target="_blank"><i class="fab fa-instagram"></i> Instagram</a></li>
            </ul>
        </div>
    </div>

    <script src="js/java.js"></script>
    <!--<script src="js/noticia-carrucel.js"></script>-->
    <script src="js/pogramacion.js"></script>
</body>
</html>
