<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/candelaria.css">
    <link rel="stylesheet" href="../estiloCelular.css">
    <link rel="icon" href="../img/ixon.jpg">
    <title>SOY CANDELARIA</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <img src="../img/nuevo logo011.png" alt="iconA" class="nav-banner">
            <a href="index.php" class="logo">ARTEMUSA TV</a>
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
            <li><a href="candelaria.php">Soy Candelaria</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="../informacion/informacion.php">Informacion</a></li>
            <li><a href="../contacto/contacto.php">Contacto</a></li>
            <li><a href="/Practicas/artemusaTV/app/views/login.php">Iniciar sesión</a></li>
        </ul>
    </nav>

    <div class="main-container">
        <!-- Columna izquierda: Carrusel de noticias -->
        <div class="left-column">
            <h2>Noticias</h2>
            <ul class="news-carousel" id="news-carousel">
                <?php
                // 📌 Ruta absoluta al archivo JSON del trabajador
                $ruta = __DIR__ . "/../../trabajador/candelaria/data/candelaria.json";

                if (file_exists($ruta)) {
                    $jsonData = file_get_contents($ruta);
                    $noticias = json_decode($jsonData, true);

                    if (!empty($noticias)) {
                        // Ordenar por fecha (más recientes primero)
                        usort($noticias, function ($a, $b) {
                            return strtotime($b['fecha'] ?? '1970-01-01') - strtotime($a['fecha'] ?? '1970-01-01');
                        });

                        // Mostrar solo las últimas 5
                        $ultimasNoticias = array_slice($noticias, 0, 5);

                        foreach ($ultimasNoticias as $noticia) {
                            $titulo    = htmlspecialchars($noticia['titulo']    ?? '');
                            $contenido = htmlspecialchars($noticia['contenido'] ?? '');
                            $fecha     = htmlspecialchars($noticia['fecha']     ?? '');
                            
                            // 📌 Asegurar ruta de la imagen
                            $imagen = !empty($noticia['imagen']) 
                                ? "../../trabajador/candelaria/uploads/" . basename($noticia['imagen']) 
                                : "../../trabajador/candelaria/uploads/default.jpg";

                            // Recortar contenido para vista previa
                            $descripcion = (strlen($contenido) > 120) 
                                ? substr($contenido, 0, 120) . "..." 
                                : $contenido;

                            echo "<li class='noticia-item'>
                                    <img src='{$imagen}' 
                                        alt='{$titulo}' 
                                        data-contenido='{$contenido}' 
                                        data-titulo='{$titulo}'
                                        data-fecha='{$fecha}'>
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

            <!-- Modal -->
            <div id="imgModal" class="img-modal">
                <span class="close">&times;</span>
                <div class="modal-body">
                    <img id="modalImg" src="">
                    <div class="modal-texto">
                        <h2 id="caption"></h2>
                        <p id="contenido"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna central: Pantalla de transmisión -->
        <div class="center-column">
            <h1>🔴 EN VIVO</h1>
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
                <h2 id="live-title">XLVIII CONCURSO REGIONAL DE SIKURIS</h2>
                <p id="live-description">
                    Clasificatorio a la Festividad Virgen de la Candelaria 2026
                    La Federación Regional de Folklore y Cultura de Puno da a conocer la lista oficial de presentación de conjuntos participantes en el 
                    XLVIII Concurso Regional de Sikuris, clasificatorio a la Festividad Virgen de la Candelaria 2026.
                </p>
            </div>

            <!-- CRONOGRAMA -->
            <div class="tiktok-section">
                <h2>CRONOGRAMA DE PARTICIPACIÓN OFICIAL</h2>
                <div class="shorts-grid">
                    <div class="cronograma-card">
                        <h3>XLVIII Concurso Regional de Sikuris</h3>
                        <h2>Clasificatorio a la Festividad Virgen de la Candelaria 2026</h2>
                        <a href="https://maps.app.goo.gl/fAk17xmqVwxdS7VR6" target="_blank"><h4>Coliseo Cerrado – El Collao, Ilave</h4></a>
                        <p class="fecha">📅 Domingo 28 de setiembre de 2025</p>
                        
                        <ul class="cronograma-list">
                            <li><b>EXHIB:</b> Conjunto Juvenil de Zampoñistas Raimondinos</li>
                            <li><b>EXHIB:</b> Zampoñada de la I.E.S. Politécnico Regional "Don Bosco" – Ilave</li>
                            <li>1. Conjunto Juvenil 24 de Junio del Barrio San José – Ilave – El Collao</li>
                            <li>2. Expresión de Arte y Cultura Q'óri Waynas de Caracoto</li>
                            <li>3. Asociación Cultural de Arte y Vientos Aymara Sikuris Wila Taki – Ilave</li>
                            <li>4. Agrupación Cultural Sicuris "Claveles Rojos" de Huancané</li>
                            <li>5. Agrupación Musical de Vientos Sikuris Sentimiento Acoreño</li>
                            <li>6. Internacional Grupo de Arte Sikuris Los Chasquis de Coasia – Vilquechico</li>
                            <li>7. Conjunto de Sikuris Glorioso San Carlos – Puno</li>
                            <li>8. Asociación Cultural de Sikuris Lully Marka – Juli</li>
                            <li>9. Asociación Cultural de Sikuris Emblemáticos Huayruros – Puno</li>
                            <li>10. Asociación Cultural Sicuris Suma Chuyma de Molloco – Acora</li>
                            <li>11. Suri Sikuris Ciudad del Lago – Puno</li>
                            <li>12. Conjunto de Zampoñistas Juventud Paxa "Jupax"</li>
                            <li>13. Expresión Cultural Milenarios de Sikuris Internacional Los Rosales – Rosaspata, Huancané</li>
                            <li>14. Sikuris 27 de Junio Nueva Era – Puno</li>
                            <li>15. Taller de Arte Popular "Yawar Inca" – Juliaca</li>
                            <li>16. Sociedad de Expresión Cultural Sikuris Wara Wara Wayras – Huatasani</li>
                            <li>17. Agrupación Sentimiento Cultural Sikuris 19 de Setiembre – Huancané</li>
                            <li>18. Agrupación Zampoñistas Proyecto Puno</li>
                            <li>19. Conjunto Milenario de Sikuris 12 de Diciembre – El Collao</li>
                            <li>20. Agrupación de Expresión Cultural de Sikuri y Danza Los Bosques – Huancané</li>
                            <li>21. Asociación Cultural de Arte Zampoñistas Confraternidad – Acora</li>
                            <li>22. Organización Cultural Armonía de Vientos Huj'maya – Puno</li>
                            <li>23. Centro de Expresión Cultural Sikuris 12 de Julio Inchupalla – Huancané</li>
                            <li>24. Asociación de Ayarachis Somos Patrimonio de la Cosmovisión Andina – Paratia, Lampa</li>
                            <li>25. Comunidad de Arte y Cultura Lupaka – Puno</li>
                            <li>26. Organización Cultural Wiñay Quta Marka de Ccota – Platería</li>
                            <li>27. Conjunto de Arte y Folklore Sicuris Juventud Obrera</li>
                            <li>28. Asociación Cultural Sangre Indomable – Azángaro</li>
                            <li>29. Sociedad Centro Social de Folklore y Cultura: Sikuris y Danzas Autóctonas "Fundación Pokopaka" – Huancané</li>
                            <li>30. Asociación Cultural 11 de Noviembre "Rijchariy Wayra"</li>
                            <li>31. Asociación de Expresión Cultural Juvenil 29 de Setiembre – Ilave</li>
                            <li>32. Conjunto de Músicos y Danzas Autóctonos "Wiñay Qhantati" – Ururi Conima</li>
                            <li>33. Asociación Juvenil Cabanillas Sikuris AJC</li>
                            <li>34. Asociación La Voz Cultural Khantus 13 de Mayo – Huayrapata</li>
                            <li>35. Agrupación Cultural de Sikuris Juventud Janansaya – Quilcapuncu, San Antonio de Putina</li>
                            <li>36. Agrupación de Zampoñistas del Altiplano del Barrio Huajsapata – Puno</li>
                            <li>37. Asociación Cultural de Sicuris Proyecto Pariwanas – Huancané</li>
                            <li>38. Asociación Cultural de Sikuris "Fuerza Joven" – Puno</li>
                            <li>39. Zampoñistas Nuevo Impacto – Acora</li>
                            <li>40. Agrupación Juvenil Nuevo Amanecer Sikuris "Inti Marka" – Coata</li>
                            <li>41. Conjunto Sikuris 15 de Mayo de Cambria – Conima</li>
                            <li>42. Conjunto de Zampoñistas "Expresión Cultural" del Centro de Ocoña – Ilave</li>
                            <li>43. Agrupación de Sikuris Raíces Aymaras – Ilave "ASIKUR"</li>
                            <li>44. Asociación Cultural de Sikuris Intercontinentales Aymaras – Huancané</li>
                            <li>45. Asociación Cultural Genuinos Ayarachis – Paratia, Lampa</li>
                            <li>46. Asociación Sociedad Sikuris Proyecto Peña Blanca – Santa Lucía, Lampa</li>
                            <li>47. Asociación Juvenil de Sikuris y Zampoñas Wayra Marka – Juliaca</li>
                            <li>48. Centro Cultural Melodías El Collao – Ilave</li>
                            <li>49. Agrupación Cultural Sikuris Sentimiento Rosal Andino – Cabana</li>
                            <li>50. Conjunto de Sikuris Centro Cultural 2 de Febrero de Sucuni – Conima</li>
                            <li>51. Taller de Arte, Música y Danza "Real Asunción" – Juli</li>
                            <li>52. Grupo de Arte 14 de Setiembre – Moho</li>
                            <li>53. Asociación Cultural Asiruni Estrella – Calapuja, Lampa</li>
                            <li>54. Asociación Folklórica Ayarachis Riqchary Huayna – Cuyo Cuyo, Sandia</li>
                            <li>55. Agrupación Sociedad Cultural Autóctono Sikuris Wila Marka – Conima</li>
                            <li>56. Conjunto de Zampoñistas "Cajas Reales" – Chucuito, Herederos Milenarios</li>
                            <li>57. Centro Cultural Sentimiento Sikuris Los Vicuñas de la Inmaculada – Lampa</li>
                            <li>58. Agrupación Cultural de Música y Danzas Autóctonas Sikuris 29 de Setiembre – Chillcapata, Conima</li>
                            <li>59. Asociación Cultural Sikuris Kalacampana – Chucuito</li>
                            <li>60. Asociación Cultural Música Danza Sikuris Viento Andino Nueva Era</li>
                            <li>61. Asociación Juvenil Sikuris Kantutas Rojas – Isaňura, Capachica, Puno</li>
                            <li>62. Asociación de Zampoñistas Juventud Mañazo</li>
                            <li>63. Expresión Cultural Sikuris Inmortales Hatun Jachas – Putina</li>
                            <li>64. Auténticos Ayarachis de Antalla – Palca, Lampa</li>
                            <li>65. Conjunto de Zampoñas Juventud Central – Chucuito, Puno</li>
                            <li>66. Conjunto de Sikuris Legendario Qheny Sankayo – Huatta, Conima</li>
                            <li>67. Conjunto de Sicuris Proyecto Cultural Wiñay Panqara Marka – Moho</li>
                            <li>68. Asociación Cultural Zampoñistas Arco Blanco – Puno</li>
                            <li>69. Asociación Juvenil Carabaya Sikuris 8 de Diciembre – Macusani</li>
                            <li>70. Conjunto de Danzas y Música Autóctona Qhantati Ururi – Conima</li>
                            <li>71. Centenario Conjunto Sicuris del Barrio Mañazo</li>
                            <li>72. Asociación Cultural de Sikuris Los Aymaras – Huancané</li>
                            <li>73. Centro de Expresión Cultural Andino Sikuris Jurimarka Occopampa – Moho</li>
                            <li>74. Centro de Expresión Cultural de Arte Milenario Originarias Ayarachis Chullunquiani – Palca, Lampa</li>
                            <li>75. Agrupación Sentimiento Sikuris de Ingeniería Civil</li>
                            <li>76. Sikuris Raíces Andinos Los Quechuas (ASIRAQ) – Santa Lucía</li>
                            <li>77. Asociación de Zampoñistas y Danzas Autóctonas San Francisco de Borja – Yunguyo</li>
                            <li>78. Centro de Expresión Cultural Wayra Marka – San Román</li>
                            <li>79. Asociación Juvenil Puno Sikuris 27 de Junio (AJP)</li>
                            <li>80. Asociación Cultural Zampoñistas Lacustre del Barrio José Antonio Encinas – Puno</li>
                            <li>81. Cultural de Arte Milenario Heraldos Sangre Aymara – Ilave</li>
                            <li>82. Auténticos Ayarachis Tawantin Ayllu – Cuyo Cuyo, Sandia</li>
                            <li>83. Centro de Expresión Cultural Sikuris "Sentimiento Q'ori Wayra" – San Antonio de Putina</li>
                            <li>84. Agrupación Cultural Milenaria de Sikuris Internacional Huarihumas – Rosaspata, Huancané</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna derecha -->
        <div class="right-column">
            <div class="card">
                <h3>🎥 Video Publicitario</h3>

                <!-- Video -->
                <video controls autoplay muted loop>
                    <source src="../../publicidad/video1.mp4" type="video/mp4">
                    Tu navegador no soporta el formato de video.
                </video>

                <!-- Imagen -->
                <img src="../../publicidad/sikuris.jpg" alt="sikuris" class="publi-img">

                <video controls autoplay muted loop>
                    <source src="../../publicidad/sikuris1.1.mp4" alt="sikuris video" type="video/mp4">
                    tu navegador no soporta el formato del video
                </video>
            </div>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <div class="footer-column">
            <p>© 2025 ARTEMUSA TV<br>Todos los derechos reservados</p>
        </div>
        <div class="footer-column">
            <p>Contacto: <a href="mailto:artemusatv@gmail.com">artemusatv@gmail.com</a></p>
            <p>Celular: <a href="tel:+51997334477">997 334 477</a></p>
            <p>Ubicación: <a href="https://maps.app.goo.gl/RMpHgF72i2AsMyXf6" target="_blank" rel="noopener noreferrer">
            <p>Horario: Lunes a Viernes 08:00 - 20:00</p>
        </div>
        <div class="footer-column">
            <h4>Síguenos</h4>
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/artemusatelevision" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://www.youtube.com/@artemusatelevision" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
                <li><a href="https://www.tiktok.com/@artemusa_tv" target="_blank"><i class="fab fa-tiktok"></i> TikTok</a></li>
            </ul>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("imgModal");
        const modalImg = document.getElementById("modalImg");
        const captionText = document.getElementById("caption");
        const contenidoText = document.getElementById("contenido");
        const closeBtn = modal.querySelector(".close");

        // Abrir modal al hacer click en imagen
        document.querySelectorAll(".noticia-item img").forEach(img => {
            img.addEventListener("click", () => {
                modal.style.display = "flex";
                modalImg.src = img.src;
                captionText.innerText = img.alt; // título
                contenidoText.innerText = img.dataset.contenido; // contenido
            });
        });

        // Cerrar con la X
        closeBtn.addEventListener("click", () => {
            modal.style.display = "none";
        });

        // Cerrar si se hace click fuera del modal
        modal.addEventListener("click", (e) => {
            if (e.target === modal) {
                modal.style.display = "none";
            }
        });
    });
    </script>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("menu-toggle");
    const navLinks = document.getElementById("nav-links");

    toggle.addEventListener("click", () => {
        navLinks.classList.toggle("active");
    });
    });
    </script>
</body>
</html>