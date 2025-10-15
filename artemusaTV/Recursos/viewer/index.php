<?php
session_start();

// 🚫 Evitar cargar contenido guardado en caché o historial
header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// 🚷 Si no hay sesión, redirige al login
if (!isset($_SESSION['usuario'])) {
    // Evita que el navegador use la página previa del historial
    echo "<script>
        window.location.replace('/app/views/login.php');
    </script>";
    exit();
}

// ⚡ Refuerza seguridad: evita reutilización de sesiones viejas
session_regenerate_id(true);

// =======================
// 🔗 Canal ARTEMUSA TV HD
// =======================
$m3uUrl = "http://64.76.204.10:25461/get.php?username=puno&password=puno&type=m3u&output=hls";
$m3uContent = @file_get_contents($m3uUrl);

$canalBuscado = "ARTEMUSA TV HD";
$canalUrl = "";

if ($m3uContent !== false) {
    $lineas = explode("\n", $m3uContent);
    $nombre = "";

    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (strpos($linea, "#EXTINF:") === 0) {
            $partes = explode(",", $linea, 2);
            $nombre = $partes[1] ?? "";
        } elseif ($linea !== "" && !str_starts_with($linea, "#")) {
            if (stripos($nombre, $canalBuscado) !== false) {
                $canalUrl = $linea;
                break;
            }
        }
    }
}

// 📅 Fecha objetivo: lunes 2 de febrero de 2026 a las 00:00:00
$fechaObjetivo = "2026-02-02 00:00:00";
$timestamp = strtotime($fechaObjetivo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="img/ixon.jpg">
    <link rel="stylesheet" href="css/style.css?v=1.0">
    <link rel="stylesheet" href="../estiloCelular.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>ARTEMUSA TV</title>
    <style>
        /* ==========================
        Menú de Usuario (dropdown)
        ========================== */
        .user-menu {
            position: relative;
        }

        .user-menu > a {
            cursor: pointer;
            color: #fff;
            font-weight: 500;
            padding: 8px 12px;
            border-radius: 5px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .user-menu > a:hover {
            color: #ffba00;
            background-color: rgba(255, 255, 255, 0.1);
        }

        /* Dropdown oculto por defecto */
        .user-menu .dropdown {
            display: none;
            position: absolute;
            top: 120%;
            right: 0;
            background: #1c1c1c;
            border-radius: 12px;
            padding: 12px 16px;
            list-style: none;
            min-width: 300px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.5);
            z-index: 9999;

            /* estilo horizontal */
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-around;

            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        /* Cada item dentro del menú */
        .user-menu .dropdown li {
            color: #fff;
            font-size: 0.9rem;
            white-space: nowrap;
        }

        /* Link dentro del dropdown */
        .user-menu .dropdown li a {
            color: #ff4c4c;
            text-decoration: none;
            font-weight: bold;
            padding: 6px 10px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .user-menu .dropdown li a:hover {
            color: #fff;
            background: #ff4c4c;
        }

        /* Mostrar con animación */
        .user-menu:hover .dropdown {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        /*---------------------------------*/
        .news-carousel {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .noticia-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.3); /* 🔥 línea más suave sobre azul */
            padding-bottom: 10px;
        }

        .noticia-item img {
            width: 100px;   /* 🔥 más grandes */
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
            border: 2px solid white; /* 🔥 marco blanco para que se note */
        }

        .texto-noticia h4 {
            margin: 0;
            font-size: 16px;
            font-weight: bold;
            color: #fff; /* 🔥 blanco sobre fondo azul */
        }

        .texto-noticia p {
            margin: 3px 0 0;
            font-size: 14px;
            color: #f0f0f0; /* 🔥 gris clarito, contraste mejor */
        }

        .more-news-link {
            display: inline-block;
            margin-top: 10px;
            font-weight: bold;
            color: #fff; /* 🔥 blanco */
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <img src="img/nuevo_logo011.png" alt="iconA" class="nav-banner">
            <a href="index.php" class="logo">ARTEMUSA TV</a>
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

         <ul class="nav-links" id="nav-links">
            <li><a href="index.php">Inicio</a></li>
            <li><a href="pogramasN/index.php">Noticias</a></li>
            <li><a href="candelaria/candelaria.php">Soy Candelaria</a></li>
            <li><a href="pogramas/pogramas.php">Programas</a></li>
            <li><a href="informacion/informacion.php">Informacion</a></li>
            <li><a href="contacto/contacto.php">Contacto</a></li>

            <!-- Menú de usuario -->
            <li class="user-menu">
                <a>
                    <?= $_SESSION['usuario'] ?? 'Invitado' ?> ⬇
                </a>
                <ul class="dropdown">
                    <li>Correo: <?= htmlspecialchars($_SESSION['correo'] ?? '') ?></li>
                    <li>Rol: <?= htmlspecialchars($_SESSION['rol'] ?? '') ?></li>
                    <li><a href="../../public/logout.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="main-container">
        <!-- Columna izquierda: Carrusel de noticias -->
        <div class="left-column">
            <h2>Noticias</h2>
            <ul class="news-carousel" id="news-carousel">
                <?php
                // 📌 Ruta absoluta al archivo JSON del trabajador
                $ruta = __DIR__ . "/../trabajador/pogramasN/data/noticias.json";

                if (file_exists($ruta)) {
                    $jsonData = file_get_contents($ruta);
                    $noticias = json_decode($jsonData, true);

                    if (!empty($noticias)) {
                        // Ordenar por fecha (más recientes primero)
                        usort($noticias, function ($a, $b) {
                            return strtotime($b['fecha']) - strtotime($a['fecha']);
                        });

                        // Mostrar solo las últimas 5
                        $ultimasNoticias = array_slice($noticias, 0, 5);

                        foreach ($ultimasNoticias as $noticia) {
                            $titulo = htmlspecialchars($noticia['titulo'] ?? '');
                            $contenido = htmlspecialchars($noticia['contenido'] ?? '');
                            
                            // 📌 Asegurar que la ruta de la imagen sea válida
                            $imagen = !empty($noticia['imagen']) 
                                ? "../trabajador/pogramasN/" . ltrim($noticia['imagen'], "/") 
                                : "uploads/default.jpg";

                            // Recortar contenido
                            $descripcion = (strlen($contenido) > 120) 
                                ? substr($contenido, 0, 120) . "..." 
                                : $contenido;

                            echo "<li class='noticia-item'>
                                    <img src='{$imagen}' alt='Imagen de noticia'>
                                    <div class='texto-noticia'>
                                        <h4>{$titulo}</h4>
                                        <p>{$descripcion}</p>
                                    </div>
                                </li>";
                        }
                    } else {
                        echo "<li>No hay noticias disponibles</li>";
                    }
                } else {
                    echo "<li>El archivo noticias.json no existe en: {$ruta}</li>";
                }
                ?>
            </ul>
            <a href="pogramasN/index.php" class="more-news-link">Ver todas las noticias</a>
        </div>

        <!-- Columna central: Pantalla de transmisión -->
        <div class="center-column">
            <!-- Pantalla de transmisión //////////////////////////////////////////////////////////// -->
            <div class="live-screen" style="position: relative; width: 100%; max-width: 1200px; padding-bottom: 56.25%; /* 16:9 */ height: 0; margin: 0 auto;">
                <iframe 
                    src="https://ssh101.com/securelive/index.php?id=artemusatv02&adult=yes"
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;"
                    allow="autoplay; fullscreen"
                    allowfullscreen>
                </iframe>
            </div>
            

            <!-- Información dinámica de la transmisión debajo del video -->
            <div class="transmission-info">
                <h2 id="live-title">🔴 Señal 24/7 de Artemusa TV</h2>
                <p id="live-description">
                    Disfruta de nuestra señal abierta (canal 15 en Puno) con programación variada las 24 horas: 
                    noticias en la mañana y la noche, además de novelas, películas y programas especiales durante el día.
                </p>
            </div>

            <div class="tiktok-section">
                <h2>🎬 TikToks Destacados</h2>
                <div class="shorts-grid">

                    <!-- TikTok 1 -->
                    <div class="shorts-card">
                        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@artemusa_tv/video/7484879840802295095" data-video-id="7484879840802295095">
                            <section></section>
                        </blockquote>
                    </div>

                    <!-- TikTok 2 -->
                    <div class="shorts-card">
                        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@artemusa_tv/video/7484753710636190981" data-video-id="7484753710636190981">
                            <section></section>
                        </blockquote>
                    </div>

                    <!-- TikTok 3 -->
                    <div class="shorts-card">
                        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@artemusa_tv/video/7480621623976987959" data-video-id="7480621623976987959">
                            <section></section>
                        </blockquote>
                    </div>

                    <!-- TikTok 4 -->
                    <div class="shorts-card">
                        <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@artemusa_tv/video/7470288572298415366" data-video-id="7470288572298415366">
                            <section></section>
                        </blockquote>
                    </div>

                </div>
            </div>
        </div>

        <!-- Columna derecha: Cuadro adicional -->
        <div class="right-column">
            <h2>Notas / Aclaraciones</h2>

            <!-- Formulario para agregar nota -->
            <form method="POST" action="">
                <textarea name="nota" rows="4" placeholder="Escribe tu nota aquí..." required></textarea>
                <button type="submit" name="guardar_nota">Guardar Nota</button>
            </form>

            <hr>

            <!-- Mostrar notas guardadas -->
            <div class="side-box">
                <h3>Mis notas</h3>
                <?php
                $conexion = new mysqli("localhost", "artemusa_artemusa", "7j4vV2mp5V", "artemusa_artemusatvphp");
                if ($conexion->connect_errno) {
                    die("Error de conexión: " . $conexion->connect_error);
                }

                // Guardar nota
                if (isset($_POST['guardar_nota'])) {
                    $nota = trim($_POST['nota']);
                    $usuario_id = $_SESSION['usuario_id'];

                    if (!empty($nota)) {
                        $stmt = $conexion->prepare("INSERT INTO notas_trabajador (usuario_id, nota) VALUES (?, ?)");
                        $stmt->bind_param("is", $usuario_id, $nota);
                        $stmt->execute();
                        $stmt->close();

                        echo "<p style='color:green;'>✅ Nota guardada</p>";
                    }
                }

                // Mostrar notas del usuario actual
                $usuario_id = $_SESSION['usuario_id'];
                $resultado = $conexion->query("SELECT id, usuario_id, nota, creado_en FROM notas_trabajador ORDER BY creado_en DESC");

                if ($resultado->num_rows > 0) {
                    echo "<ul>";
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<li>
                                <b>{$row['creado_en']}</b> 
                                <span style='color:#d60000;'>(Usuario: {$row['usuario_id']})</span><br>
                                {$row['nota']}
                            </li><br>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No hay notas guardadas aún.</p>";
                }

                $conexion->close();
                ?>
            </div>

            <div class="card publicidad">
                <h3>📢 Soy Candelaria</h3>
                <a href="candelaria/candelaria.php"><img src="../publicidad/candelaria.jpg" alt="candelaria"></a>
                <h3>⏳ Contador hasta el inicio de la Candelaria 2026</h3>
                <div id="contador"></div>

                <h3>📌 Publicite aquí (cel: 957627791):</h3>
                <div class="ads">
                    <a href="https://www.facebook.com/conectocompany/?locale=es_LA" target="_blank"><img src="../publicidad/conecto.png" alt="conecto"></a>
                    <a href="https://cultural.edu.pe/puno/" target="_blank"><img src="../publicidad/cultural.jpg" alt="cultural"></a>
                    <a href="https://www.facebook.com/DiresaPunoOficial?locale=es_LA" target="_blank"><img src="../publicidad/vacuna.jpg" alt="vacuna"></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <footer class="footer">
        <div class="footer-container">
        
            <div class="footer-column">
                <h4>ARTEMUSA TV</h4>
                <p>© 2025 ARTEMUSA TV<br>Todos los derechos reservados</p>
                <p class="footer-slogan">Inspirando con arte y cultura.</p>
            </div>

            <div class="footer-column">
                <h4>Contáctanos</h4>
                <p><i class="fas fa-envelope"></i> 
                    <a href="mailto:artemusatv@gmail.com">artemusatv@gmail.com</a></p>
                <p><i class="fas fa-phone"></i> 
                    <a href="tel:+51997334477">997 334 477</a></p>
                <p><i class="fas fa-map-marker-alt"></i> 
                    <a href="https://maps.app.goo.gl/RMpHgF72i2AsMyXf6" target="_blank" rel="noopener noreferrer">Ubicación</a></p>
                <p><i class="fas fa-clock"></i> Lunes a Viernes 08:00 - 20:00</p>
            </div>

            <div class="footer-column">
                <h4>Síguenos</h4>
                <ul class="social-icons">
                    <li><a href="https://www.facebook.com/artemusatelevision" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                    <li><a href="https://www.youtube.com/@artemusatelevision" target="_blank"><i class="fab fa-youtube"></i></a></li>
                    <li><a href="https://www.tiktok.com/@artemusa_tv" target="_blank"><i class="fab fa-tiktok"></i></a></li>
                </ul>
            </div>

        </div>

        <div class="footer-bottom">
            <p>Desarrollado por <strong>ARTEMUSA Tech</strong></p>
        </div>
    </footer>

    <script src="js/java.js"></script>
    <script>
        // Script para abrir/cerrar menú en móvil
        const toggle = document.getElementById('menu-toggle');
        const links = document.getElementById('nav-links');

        toggle.addEventListener('click', () => {
            links.classList.toggle('active');
        });
    </script>
    <script>
        // 📌 Obtener la fecha objetivo desde PHP
        const fechaObjetivo = new Date(<?php echo $timestamp * 1000; ?>);

        function actualizarContador() {
            const ahora = new Date();
            const diferencia = fechaObjetivo - ahora;

            if (diferencia <= 0) {
                document.getElementById("contador").innerHTML = "¡Ha llegado el día!";
                return;
            }

            const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
            const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutos = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
            const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

            document.getElementById("contador").innerHTML = 
                dias + "d " + horas + "h " + minutos + "m " + segundos + "s ";
        }

        // Actualizar cada segundo
        setInterval(actualizarContador, 1000);
        actualizarContador();
    </script>
    <!-- Pie de página <script src="js/noticia-carrucel.js"></script>-->
    <!-- <script src="js/pogramacion.js"></script>-->
    <!-- Script de TikTok (necesario una sola vez en la página) -->
    <script async src="https://www.tiktok.com/embed.js"></script>
        <script>
        var video = document.getElementById('video');
        var videoSrc = "<?php echo $canalUrl; ?>"; // tu m3u8 dinámico

        if (Hls.isSupported()) {
            var hls = new Hls({
                liveSyncDuration: 5,          // segundos de atraso respecto al vivo
                liveMaxLatencyDuration: 15,   // máximo retraso tolerado
                manifestLoadingTimeOut: 20000,
                manifestLoadingMaxRetry: 20,
                manifestLoadingRetryDelay: 2000,
                levelLoadingMaxRetry: 20,
                levelLoadingRetryDelay: 2000,
            });

            hls.loadSource(videoSrc);
            hls.attachMedia(video);

            // Reintentos automáticos si falla
            hls.on(Hls.Events.ERROR, function (event, data) {
                if (data.fatal) {
                    switch(data.type) {
                        case Hls.ErrorTypes.NETWORK_ERROR:
                            console.log("Error de red, reintentando...");
                            hls.startLoad();
                            break;
                        case Hls.ErrorTypes.MEDIA_ERROR:
                            console.log("Error de medios, recuperando...");
                            hls.recoverMediaError();
                            break;
                        default:
                            console.log("Error fatal, reiniciando...");
                            hls.destroy();
                            hls = new Hls();
                            hls.loadSource(videoSrc);
                            hls.attachMedia(video);
                            break;
                    }
                }
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            // Safari soporta HLS nativo
            video.src = videoSrc;
            video.play();
        }
    </script>
</body>
</html>
