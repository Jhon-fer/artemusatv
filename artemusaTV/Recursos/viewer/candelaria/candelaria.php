<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /app/views/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/candelaria.css?v=2">
    <link rel="stylesheet" href="../estiloCelular.css">
    <link rel="icon" href="../img/ixon.jpg">
    <title>SOY CANDELARIA</title>
</head>
<body>
    <nav class="navbar">
        <div class="nav-left">
            <img src="../img/nuevo_logo011.png" alt="iconA" class="nav-banner">
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

            <!-- Menú de usuario -->
            <li class="user-menu">
                <a><?= $_SESSION['usuario'] ?? 'Invitado' ?> ⬇</a>
                <ul class="dropdown">
                    <li>Correo: <?= htmlspecialchars($_SESSION['correo'] ?? '') ?></li>
                    <li>Rol: <?= htmlspecialchars($_SESSION['rol'] ?? '') ?></li>
                    <li><a href="/public/logout.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div class="viedo-presentacion">
        <video autoplay muted loop playsinline>
            <source src="../../publicidad/vido pagina.mp4" type="video/mp4">
            Tu navegador no soporta el formato de video.
        </video>
    </div>

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
        </div> <!-- /Columna izquierda -->

        <!-- Columna central: Pantalla de transmisión -->
        <div class="center-column">
            <h1>🔴 REPETICIÓN</h1>
            <div class="live-screen" style="position: relative; width: 100%; max-width: 1200px; padding-bottom: 56.25%; height: 0; margin: 0 auto;">
                <iframe
                    src="https://www.youtube.com/embed/kX_SKSceGik"
                    width="560"
                    height="315"
                    style="position:absolute; top:0; left:0; width:100%; height:100%; border:none; overflow:hidden;"
                    scrolling="no"
                    frameborder="0"
                    allowfullscreen
                    allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share">
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

            <!-- ============================================
                VENERACIÓN Y PARADA EN HONOR A LA SANTÍSIMA
                VIRGEN DE LA CANDELARIA - 2026
            =============================================== -->
            <div class="tiktok-section">
                <h2 class="titulo-cronograma">
                    VENERACIÓN Y PARADA DE DANZAS AUTÓCTONAS EN HONOR A LA SANTÍSIMA<br>
                    VIRGEN DE LA CANDELARIA – 2026
                </h2>

                <div class="shorts-grid">

                    <!-- Día 1 -->
                    <div class="cronograma-card">
                    <h3>Primer Día: Lunes 09 de Febrero del 2026</h3>
                    <p class="fecha">🕗 Hora de Inicio: 08:00 a.m.</p>

                    <ul class="cronograma-list">
                        <li><strong>Exhibición:</strong> ORGANIZACIÓN CULTURAL ARMONÍA DE VIENTOS HUJ'MAYA</li>
                        <li><strong>Exhibición:</strong> CONJUNTO DE SIKURIS GLORIOSO SAN CARLOS</li>

                        <li>1. CONJUNTO DE ZAMPOÑAS Y DANZAS UNI</li>
                        <li>2. CONJUNTO CLASIFICADO SALIDA DE MANCO CAPAC Y MAMA OCLLO 2025</li>
                        <li>3. AGRUPACIÓN DE SIKURIS RAÍCES AYMARAS – ILAVE "ASIKUR"</li>
                        <li>4. FRATERNIDAD CAPORALES VIRGEN DE LA CANDELARIA "VIENTOS DEL SUR"</li>
                        <li>5. ASOCIACIÓN CULTURAL ZAMPOÑISTAS LACUSTRE DEL BARRIO JOSÉ ANTONIO ENCINAS</li>
                        <li>6. MORENADA VIRGEN DE LA CANDELARIA - MANDACHITOS</li>
                        <li>7. ASOCIACIÓN FOLKLÓRICA DIABLADA "CENTINELAS DEL ALTIPLANO"</li>
                        <li>8. ASOCIACIÓN CULTURAL DE SIKURIS LOS AYMARAS DE HUANCANÉ</li>
                        <li>9. ASOCIACIÓN FOLKLÓRICA CAPORALES SAN VALENTÍN</li>
                        <li>10. WACA WACA DEL BARRIO PORTEÑO</li>
                        <li>11. JUVENTUD TINKUS DEL BARRIO PORTEÑO</li>
                        <li>12. ASOCIACIÓN CULTURAL "MORENADA AZOGUINI"</li>
                        <li>13. CONJUNTO DE DANZAS Y MÚSICA AUTÓCTONA QHANTATI URURI DE CONIMA</li>
                        <li>14. CONJUNTO FOLKLÓRICO LOS CAPORALES DE LA TUNTUNA DEL BARRIO MIRAFLORES</li>
                        <li>15. CONJUNTO DE ZAMPOÑAS "EXPRESIÓN CULTURAL" DEL CENTRO DE OCOÑA – TRADICIONAL REY MORENO SAN ANTONIO</li>
                        <li>17. AGRUPACIÓN KULLAHUADA VICTORIA</li>
                        <li>18. EXPRESIÓN CULTURAL MILENARIOS DE SIKURIS INTERNACIONAL LOS ROSALES – ROSASPATA, HUANCANÉ</li>
                        <li>19. ESCUELA DE ARTE "JOSÉ CARLOS MARIÁTEGUI" ZAMBOS TUNDIQUES</li>
                        <li>20. FABULOSA MORENADA INDEPENDENCIA</li>
                        <li>21. DIABLADA CONFRATERNIDAD VICTORIA</li>
                        <li>22. AGRUPACIÓN SANGRE CHUMBIVILCANA – DANZA HUAYLIA CHUMBIVILCANA – CUSCO</li>
                        <li>23. GRUPO DE ARTE 14 DE SEPTIEMBRE – MOHO</li>
                        <li>24. ASOCIACIÓN CULTURAL FOLKLÓRICA "LEGADO CAPORAL"</li>
                        <li><strong>Invitado:</strong> WIFALAS SAN FRANCISCO JAVIER DE MUÑANI (Campeón Danzas Originarios 2025)</li>
                        <li>25. AGRUPACIÓN DE ZAMPOÑISTAS DEL ALTIPLANO DEL BARRIO HUAJSAPATA – PUNO</li>
                        <li>26. AUTÉNTICOS AYARACHIS TAWANTIN AYLLU – CUYO CUYO, SANDIA</li>
                        <li>27. MORENADA LAYKAKOTA</li>
                        <li>28. CENTRO SOCIAL KULLAHUADA CENTRAL – PUNO</li>
                        <li>29. AGRUPACIÓN CULTURAL SICURIS "CLAVELES ROJOS" DE HUANCANÉ</li>
                        <li>30. CONJUNTO CLASIFICADO SALIDA DE MANCO CAPAC Y MAMA OCLLO 2025</li>
                        <li>31. FRATERNIDAD ARTÍSTICA SAMBOS CAPORALES SEÑOR DE QOILLOR-RITTY</li>
                        <li>32. ASOCIACIÓN CULTURAL FOLKLÓRICA TOBAS AMAZONAS ANATA</li>
                        <li>33. CONJUNTO MORENADA "RICARDO PALMA"</li>
                        <li>34. CONJUNTO SIKURIS 15 DE MAYO DE CAMBRIA – CONIMA</li>
                        <li>35. ASOCIACIÓN DE ARTE, CULTURA Y FOLKLORE CAPORALES DE SIEMPRE – PITONES</li>
                        <li>36. ASOCIACIÓN FOLKLÓRICA ESPECTACULAR DIABLADA BELLAVISTA</li>
                        <li>37. MORENADA CENTRAL GALENO – DR. RICARDO J. RUELAS RODRÍGUEZ</li>
                        <li>38. ASOCIACIÓN FOLKLÓRICA WACA WACA SANTA ROSA</li>
                        <li>39. CONJUNTO FOLKLÓRICO LA LLAMERADA DEL CLUB JUVENIL ANDINO DE LAMPA</li>
                        <li>40. ESCUELA INTERNACIONAL DEL FOLKLORE CAPORALES DEL SUR – PUNO</li>
                        <li>41. CENTENARIO CONJUNTO SICURIS DEL BARRIO MAÑAZO</li>
                        <li>42. ASOCIACIÓN MORENADA PORTEÑO</li>
                        <li>43. SOCIEDAD DE EXPRESIÓN CULTURAL SIKURIS WARA WARA WAYRAS – HUATASANI, HUANCANÉ</li>
                        <li>44. CENTRO UNIVERSITARIO DE FOLKLORE Y CONJUNTO DE ZAMPOÑAS DE LA UNIVERSIDAD NACIONAL MAYOR DE SAN MARCOS (CZSM)</li>
                        <li>45. AGRUPACIÓN CULTURAL MILENARIA DE SIKURIS INTERNACIONAL HUARIHUMA – ROSASPATA, HUANCANÉ</li>
                        <li>46. ASOCIACIÓN FOLKLÓRICA VIRGEN DE LA CANDELARIA – AFOVIC</li>
                        <li>47. CONJUNTO FOLKLÓRICO MORENADA ORKAPATA</li>
                        <li>48. ASOCIACIÓN FOLKLÓRICA DIABLADA AZOGUINI</li>
                        <li><strong>Exhibición:</strong> ASOCIACIÓN CULTURAL CAPORALES MI VIEJO SJ</li>
                    </ul>
                    </div>

                    <!-- Día 2 -->
                    <div class="cronograma-card">
                    <h3>Segundo Día: Martes 10 de Febrero del 2026</h3>
                    <p class="fecha">🕗 Hora de Inicio: 08:00 a.m.</p>

                    <ul class="cronograma-list">
                        <li>49. ASOCIACIÓN CULTURAL SANGRE INDOMABLE – AZÁNGARO</li>
                        <li>50. CONJUNTO DE ZAMPOÑISTAS JUVENTUD PAXA "JUPAX"</li>
                        <li>51. REY MORENO LAYKAKOTA</li>
                        <li>52. ASOCIACIÓN CULTURAL ECOLÓGICA ETNIAS AMAZÓNICAS DEL PERÚ – BIODANZA</li>
                        <li>53. ASOCIACIÓN CULTURAL DE SIKURIS INTERCONTINENTALES AYMARAS DE HUANCANÉ</li>
                        <li>54. ASOCIACIÓN FOLKLÓRICA CAPORALES "SAMBOS CON SENTIMIENTO Y DEVOCIÓN"</li>
                        <li>55. CONFRATERNIDAD DIABLADA SAN ANTONIO</li>
                        <li>56. COFRADÍA DE NEGRITOS CHACÓN BEATERIO DE HUÁNUCO</li>
                        <li>57. CONFRATERNIDAD CULTURAL WACAS – PUNO</li>
                        <li>58. CONJUNTO CLASIFICADO SALIDA DE MANCO CAPAC Y MAMA OCLLO 2025</li>
                        <li>59. AGRUPACIÓN SOCIEDAD CULTURAL AUTÓCTONO SIKURIS WILA MARCA – CONIMA</li>
                        <li>60. ASOCIACIÓN CULTURAL FOLKLÓRICA CAPORALES HUÁSCAR</li>
                        <li>61. TALLER DE ARTE, MÚSICA Y DANZA "REAL ASUNCIÓN" – JULI</li>
                        <li>62. PODEROSA Y ESPECTACULAR MORENADAS BELLAVISTA</li>
                        <li>63. ASOCIACIÓN DE ARTE Y FOLKLORE CAPORALES SAN JUAN BAUTISTA – PUNO</li>
                        <li>64. ASOCIACIÓN CULTURAL KULLAHUADA VIRGEN MARÍA DE LA CANDELARIA</li>
                        <li>65. ASOCIACIÓN LA VOZ CULTURAL KHANTUS 13 DE MAYO – HUAYRAPATA</li>
                        <li>67. ASOCIACIÓN CULTURAL CAPORALES CENTRALISTAS – PUNO</li>
                        <li>68. ASOCIACIÓN DE EXPRESIÓN CULTURAL JUVENIL 29 DE SETIEMBRE – ILAVE</li>
                        <li>69. ASOCIACIÓN CULTURAL GENUINOS AYARACHIS DE PARATIA – LAMPA</li>
                        <li>70. TRADICIONAL DIABLADA PORTEÑO</li>
                        <li>71. SOCIEDAD CENTRO SOCIAL DE FOLKLORE Y CULTURA "FUNDACIÓN POKOPAKA" – HUANCANÉ</li>
                        <li>72. AUTÉNTICOS AYARACHIS DE ANTALLA – PALCA, LAMPA</li>
                        <li>73. ASOCIACIÓN FOLKLÓRICA TINKUS SEÑOR DE MACHALLATA</li>
                        <li>74. CONJUNTO "REY CAPORAL INDEPENDENCIA" – PUNO</li>
                        <li>75. ASOCIACIÓN JUVENIL CABANILLAS SIKURIS AJC</li>
                        <li>76. ASOCIACIÓN FOLKLÓRICA "CAPORALES VICTORIA" – PUNO</li>
                        <li>77. CONJUNTO DE ARTE Y FOLKLORE SICURIS JUVENTUD OBRERA</li>
                        <li>78. PODEROSA ESPECTACULAR WACA WACA ALTO PUNO</li>
                        <li>79. CONFRATERNIDAD MORENADA INTOCABLES JULIACA MIA</li>
                        <li>80. CONJUNTO DE MÚSICOS Y DANZAS AUTÓCTONAS "WIÑAY QHANTATI" – URURI CONIMA</li>
                        <li>81. CAPORALES CENTRO CULTURAL ANDINO</li>
                        <li>82. CONFRATERNIDAD MORENADA SANTA ROSA – PUNO</li>
                        <li>83. ASOCIACIÓN DE ZAMPOÑISTAS Y DANZAS AUTÓCTONAS SAN FRANCISCO DE BORJA – YUNGUYO</li>
                        <li>84. ASOCIACIÓN CULTURAL DE SICURIS PROYECTO PARIWANAS – HUANCANÉ</li>
                        <li>85. ASOCIACIÓN CULTURAL DIABLADA CONFRATERNIDAD HUÁSCAR</li>
                        <li>86. CONFRATERNIDAD CENTRAL TOBAS SUR</li>
                        <li>87. CENTRO CULTURAL SENTIMIENTO SIKURIS "LAS VICUÑAS DE LA INMACULADA" – LAMPA</li>
                        <li>88. CENTRO CULTURAL MELODÍAS EL COLLAO – ILAVE</li>
                        <li>89. ASOCIACIÓN FOLKLÓRICA ANDINO AMAZÓNICO TOBAS CENTRAL PERÚ</li>
                        <li>90. ASOCIACIÓN JUVENIL PUNO SIKURIS 27 DE JUNIO (AJP)</li>
                        <li>91. GRAN MORENADA SALCEDO</li>
                        <li>92. MORENADA SAN MARTÍN</li>
                        <li>93. ASOCIACIÓN CULTURAL INCOMPARABLE GRAN DIABLADA AMIGOS DE LA PNP</li>
                        <li>94. CONJUNTO DE DANZAS ALTIPLÁNICAS DE LA UNI (TUNTUNA UNI)</li>
                        <li>95. ASOCIACIÓN ROMEOS DE CANDELARIA</li>
                        <li>96. CONFRATERNIDAD PODEROSA Y ESPECTACULAR MORENADA SAN VALENTÍN – ILAVE</li>
                        <li>97. LA GRAN CONFRATERNIDAD LLAMERADA VIRGEN GRAN COLLAVIC – PUNO</li>
                        <li><strong>Exhibición:</strong> MORENADA CENTRAL PUNO</li>
                    </ul>
                    </div>

                </div>
            </div>

            <!-- ============================================
                ORDEN DE PRESENTACIÓN
                LIX CONCURSO DE DANZAS DE TRAJES DE LUCES
                EN HONOR A LA SANTÍSIMA VIRGEN DE LA CANDELARIA – 2026
            =============================================== -->
            <div class="tiktok-section">
                <h2 class="titulo-cronograma">
                    ORDEN DE PRESENTACIÓN<br>
                    LIX CONCURSO DE DANZAS DE TRAJES DE LUCES<br>
                    EN HONOR A LA SANTÍSIMA VIRGEN DE LA CANDELARIA – 2026
                </h2>

                <p class="fecha" style="text-align:center; font-weight:bold;">
                    📍 Estadio UNA – Puno<br>
                    🗓️ Domingo 08 de febrero del 2026<br>
                    🕖 Hora de inicio: 07:00 a.m.
                </p>

                <div class="shorts-grid">

                    <!-- Día Único -->
                    <div class="cronograma-card">
                    <h3>ORDEN DE PRESENTACIÓN</h3>
                    <ul class="cronograma-list">
                        <li><strong>Exhibición:</strong> ORGANIZACIÓN CULTURAL ARMONÍA DE VIENTOS HUJ'MAYA</li>
                        <li><strong>Exhibición:</strong> CONJUNTO DE SIKURIS GLORIOSO SAN CARLOS</li>

                        <li>1. ASOCIACIÓN CULTURAL DIABLADA CONFRATERNIDAD HUÁSCAR</li>
                        <li>2. CENTRO CULTURAL MELODÍAS EL COLLAO – ILAVE</li>
                        <li>3. LA GRAN CONFRATERNIDAD LLAMERADA VIRGEN DE LA CANDELARIA CENTRAL PUNO – LA</li>
                        <li>4. ASOCIACIÓN FOLKLÓRICA ANDINO AMAZÓNICO TOBAS CENTRAL PERÚ</li>
                        <li>5. ASOCIACIÓN ROMEOS DE CANDELARIA</li>
                        <li>6. CONJUNTO DE DANZAS ALTIPLÁNICAS DE LA UNI (TUNTUNA UNI)</li>
                        <li>7. ASOCIACIÓN CULTURAL INCOMPARABLE GRAN DIABLADA AMIGOS DE LA PNP</li>
                        <li>8. CENTRO CULTURAL SENTIMIENTO SIKURIS “LAS VICUÑAS DE LA INMACULADA” – LAMPA</li>
                        <li>9. GRAN MORENADA SALCEDO</li>
                        <li>10. CONFRATERNIDAD CENTRAL TOBAS SUR</li>
                        <li>11. ASOCIACIÓN JUVENIL PUNO SIKURIS 27 DE JUNIO (AJP)</li>
                        <li>12. CONFRATERNIDAD PODEROSA Y ESPECTACULAR MORENADA SAN VALENTÍN – ILAVE</li>
                        <li>13. CONJUNTO DE ZAMPOÑAS Y DANZAS UNI</li>
                        <li>14. CONJUNTO CLASIFICADO SALIDA DE MANCO CÁPAC Y MAMA OCLLO 2025</li>
                        <li>15. SOCIEDAD DE EXPRESIÓN CULTURAL SIKURIS WARA WARA WAYRAS – HUATASANI</li>
                        <li>16. ESCUELA DE ARTE “JOSÉ CARLOS MARIÁTEGUI” ZAMBOS TUNDIQUES</li>
                        <li>17. CONFRATERNIDAD DIABLADA SAN ANTONIO</li>
                        <li>18. ASOCIACIÓN DE EXPRESIÓN CULTURAL JUVENIL 29 DE SETIEMBRE – ILAVE</li>
                        <li>19. CONJUNTO FOLKLÓRICO MORENADA ORKAPATA</li>
                        <li>20. CAPORALES CENTRO CULTURAL ANDINO</li>
                        <li>21. CONJUNTO DE MÚSICOS Y DANZAS AUTÓCTONAS “WIÑAY QHANTATI” – URURI CONIMA</li>
                        <li>22. MORENADA HUAJSAPATA</li>
                        <li>23. CONJUNTO FOLKLÓRICO LA LLAMERADA DEL CLUB JUVENIL ANDINO DE LAMPA</li>
                        <li>24. AGRUPACIÓN DE SIKURIS RAÍCES AYMARAS – ILAVE “ASIKUR”</li>
                        <li>25. ASOCIACIÓN FOLKLÓRICA DIABLADA AZOGUINI</li>
                        <li>26. CONFRATERNIDAD MORENADA SANTA ROSA – PUNO</li>
                        <li>27. ASOCIACIÓN FOLKLÓRICA CAPORALES SAN VALENTÍN</li>
                        <li>28. GRUPO DE ARTE 14 DE SEPTIEMBRE – MOHO</li>
                        <li>29. CONJUNTO DE ARTE Y FOLKLORE SICURIS JUVENTUD OBRERA</li>
                        <li>30. MORENADA CENTRAL GALENO – DR. RICARDO J. RUELAS RODRÍGUEZ</li>
                        <li>31. ASOCIACIÓN CULTURAL CAPORALES “SAMBOS CON SENTIMIENTO Y DEVOCIÓN” – PORTEÑO</li>
                        <li>32. REY MORENO LAYKAKOTA</li>
                        <li>33. ASOCIACIÓN CULTURAL SANGRE INDOMABLE – AZÁNGARO</li>
                        <li>34. PODEROSA ESPECTACULAR WACA WACA ALTO PUNO</li>
                        <li>35. COFRADÍA DE NEGRITOS CHACÓN BEATERIO DE HUÁNUCO</li>
                        <li>36. MORENADA VIRGEN DE LA CANDELARIA – MANDACHITOS</li>
                        <li>37. EXPRESIÓN CULTURAL MILENARIOS DE SIKURIS INTERNACIONAL LOS ROSALES – HUANCANÉ</li>
                        <li>38. ASOCIACIÓN LA VOZ CULTURAL KHANTUS 13 DE MAYO – HUAYRAPATA</li>
                        <li>39. ESCUELA INTERNACIONAL DEL FOLKLORE CAPORALES DEL SUR – PUNO</li>
                        <li>40. ASOCIACIÓN CULTURAL KULLAHUADA VIRGEN MARÍA DE LA CANDELARIA</li>
                        <li>41. WACA WACA DEL BARRIO PORTEÑO</li>
                        <li>42. ASOCIACIÓN FOLKLÓRICA “CAPORALES VICTORIA” – PUNO</li>
                        <li>43. ASOCIACIÓN DE ZAMPOÑISTAS Y DANZAS AUTÓCTONAS SAN FRANCISCO DE BORJA – YUNGUYO</li>
                        <li>44. AGRUPACIÓN CULTURAL MILENARIA DE SIKURIS INTERNACIONAL HUARIHUMA – HUANCANÉ</li>
                        <li>45. CONJUNTO CLASIFICADO SALIDA DE MANCO CÁPAC Y MAMA OCLLO 2025</li>
                        <li>46. TRADICIONAL DIABLADA PORTEÑO</li>
                        <li>47. TRADICIONAL REY MORENO SAN ANTONIO</li>
                        <li><strong>Invitado:</strong> WIFALAS SAN FRANCISCO JAVIER DE MUÑANI (Campeón en Danzas Originarias 2025)</li>
                        <li>48. CONFRATERNIDAD CULTURAL WACAS – PUNO</li>
                        <li>49. ASOCIACIÓN MORENADA PORTEÑO</li>
                        <li>50. AGRUPACIÓN SOCIEDAD CULTURAL AUTÓCTONO SIKURIS WILA MARCA – CONIMA</li>
                        <li>51. ASOCIACIÓN FOLKLÓRICA TINKUS SEÑOR DE MACHALLATA</li>
                        <li>52. ASOCIACIÓN CULTURAL ZAMPOÑISTAS LACUSTRE DEL BARRIO JOSÉ ANTONIO ENCINAS</li>
                        <li>53. ASOCIACIÓN CULTURAL CAPORALES CENTRALISTAS – PUNO</li>
                        <li>54. AUTÉNTICOS AYARACHIS TAWANTIN AYLLU – CUYO CUYO, SANDIA</li>
                        <li>55. ASOCIACIÓN FOLKLÓRICA ESPECTACULAR DIABLADA BELLAVISTA</li>
                        <li>56. SOCIEDAD CENTRO SOCIAL DE FOLKLORE Y CULTURA “FUNDACIÓN POKOPAKA” – HUANCANÉ</li>
                        <li>57. AGRUPACIÓN KULLAHUADA VICTORIA</li>
                        <li>58. ASOCIACIÓN CULTURAL DE SIKURIS INTERCONTINENTALES AYMARAS DE HUANCANÉ</li>
                        <li>59. ASOCIACIÓN CULTURAL ECOLÓGICA ETNIAS AMAZÓNICAS DEL PERÚ – BIODANZA</li>
                        <li>60. ASOCIACIÓN DE ARTE, CULTURA Y FOLKLORE CAPORALES DE SIEMPRE – PITONES</li>
                        <li>61. CONFRATERNIDAD MORENADA INTOCABLES JULIACA MIA</li>
                        <li>62. ASOCIACIÓN CULTURAL DE SIKURIS LOS AYMARAS DE HUANCANÉ</li>
                        <li>63. CONJUNTO DE ZAMPOÑAS “EXPRESIÓN CULTURAL” – OCOÑA, ILAVE</li>
                        <li>64. CONJUNTO “REY CAPORAL INDEPENDENCIA” – PUNO</li>
                        <li>65. ASOCIACIÓN FOLKLÓRICA WACA WACA SANTA ROSA</li>
                        <li>66. ASOCIACIÓN CULTURAL FOLKLÓRICA CAPORALES HUÁSCAR</li>
                        <li>67. MORENADA LAYKAKOTA</li>
                        <li>68. CONJUNTO FOLKLÓRICO LOS CAPORALES DE LA TUNTUNA – MIRAFLORES, PUNO</li>
                        <li>69. AGRUPACIÓN SANGRE CHUMBIVILCANA – DANZA HUAYLIA CHUMBIVILCANA – CUSCO</li>
                        <li>70. FRATERNIDAD ARTÍSTICA SAMBOS CAPORALES SEÑOR DE QOILLOR-RITTY</li>
                        <li>71. CONJUNTO SIKURIS 15 DE MAYO DE CAMBRIA – CONIMA</li>
                        <li>72. DIABLADA CONFRATERNIDAD VICTORIA</li>
                        <li>73. AGRUPACIÓN DE ZAMPOÑISTAS DEL ALTIPLANO DEL BARRIO HUAJSAPATA – PUNO</li>
                        <li>74. ASOCIACIÓN CULTURAL FOLKLÓRICA “LEGADO CAPORAL”</li>
                        <li>75. AUTÉNTICOS AYARACHIS DE ANTALLA – PALCA, LAMPA</li>
                        <li>76. ASOCIACIÓN CULTURAL FOLKLÓRICA TOBAS AMAZONAS ANATA</li>
                        <li>77. ASOCIACIÓN CULTURAL “MORENADA AZOGUINI”</li>
                        <li>78. CENTRO SOCIAL KULLAHUADA CENTRAL – PUNO</li>
                        <li>79. ASOCIACIÓN DE ARTE Y FOLKLORE CAPORALES SAN JUAN BAUTISTA – PUNO</li>
                        <li>80. CENTENARIO CONJUNTO SIKURIS DEL BARRIO MAÑAZO</li>
                        <li>81. AGRUPACIÓN CULTURAL SIKURIS “CLAVELES ROJOS” – HUANCANÉ</li>
                        <li>82. FRATERNIDAD CAPORALES VIRGEN DE LA CANDELARIA “VIENTOS DEL SUR”</li>
                        <li>83. PODEROSA Y ESPECTACULAR MORENADAS BELLAVISTA</li>
                        <li>84. ASOCIACIÓN CULTURAL DE SIKURIS PROYECTO PARIWANAS – HUANCANÉ</li>
                        <li>85. ASOCIACIÓN CULTURAL GENUINOS AYARACHIS DE PARATIA – LAMPA</li>
                        <li>86. CONJUNTO DE ZAMPOÑISTAS JUVENTUD PAXA “JUPAX”</li>
                        <li>87. CONJUNTO MORENADA “RICARDO PALMA”</li>
                        <li>88. ASOCIACIÓN JUVENIL CABANILLAS SIKURIS AJC</li>
                        <li>89. ASOCIACIÓN FOLKLÓRICA DIABLADA “CENTINELAS DEL ALTIPLANO”</li>
                        <li>90. ASOCIACIÓN FOLKLÓRICA VIRGEN DE LA CANDELARIA – AFOVIC</li>
                        <li>91. FABULOSA MORENADA INDEPENDENCIA</li>
                        <li>92. TALLER DE ARTE, MÚSICA Y DANZA “REAL ASUNCIÓN” – JULI</li>
                        <li>93. JUVENTUD TINKUS DEL BARRIO PORTEÑO</li>
                        <li>94. CONJUNTO DE DANZAS Y MÚSICA AUTÓCTONA QHANTATI URURI DE CONIMA</li>
                        <li>95. CENTRO UNIVERSITARIO DE FOLKLORE Y CONJUNTO DE ZAMPOÑAS – UNMSM (CZSM)</li>
                        <li><strong>Exhibición:</strong> ASOCIACIÓN CULTURAL CAPORALES MI VIEJO SJ</li>
                        <li><strong>Exhibición:</strong> MORENADA CENTRAL PUNO</li>
                    </ul>
                    </div>
                </div>
            </div>
        </div> <!-- /Columna central -->

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

                <!-- Segundo video -->
                <video controls autoplay muted loop>
                    <source src="../../publicidad/sikuris1.1.mp4" type="video/mp4">
                    Tu navegador no soporta el formato del video.
                </video>
            </div>
        </div> <!-- /Columna derecha -->

    </div> <!-- /main-container -->

    <!-- Pie de página -->
    <div class="footer">
        <div class="footer-column">
            <p>© 2025 ARTEMUSA TV<br>Todos los derechos reservados</p>
        </div>
        <div class="footer-column">
            <p>Contacto: <a href="mailto:artemusatv@gmail.com">artemusatv@gmail.com</a></p>
            <p>Celular: <a href="tel:+51997334477">997 334 477</a></p>
            <p>Ubicación: 
                <a href="https://maps.app.goo.gl/RMpHgF72i2AsMyXf6" target="_blank" rel="noopener noreferrer">
                    Ver en Google Maps
                </a>
            </p>
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
            const menuToggle = document.getElementById("menu-toggle");
            const navLinks = document.getElementById("nav-links");

            // Oculta el menú al cargar en móviles
            if (window.innerWidth <= 768) {
            navLinks.classList.remove("active");
            }

            // Muestra/oculta al hacer clic
            menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            });

            // Cierra el menú si se hace clic en un enlace
            navLinks.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                if (window.innerWidth <= 768) {
                navLinks.classList.remove("active");
                }
            });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const modal = document.getElementById("imgModal");
            const modalImg = document.getElementById("modalImg");
            const captionText = document.getElementById("caption");
            const contenidoText = document.getElementById("contenido");
            const closeBtn = modal.querySelector(".close");

            // Abrir modal al hacer clic en una noticia
            document.querySelectorAll(".noticia-item img").forEach(img => {
                img.addEventListener("click", () => {
                    modal.style.display = "flex";
                    modalImg.src = img.src;
                    captionText.innerText = img.alt;
                    contenidoText.innerText = img.dataset.contenido;
                });
            });

            // Cerrar modal al hacer clic en la X
            closeBtn.addEventListener("click", () => {
                modal.style.display = "none";
            });

            // Cerrar modal al hacer clic fuera del contenido (modal-body)
            modal.addEventListener("click", (e) => {
                if (e.target === modal) {
                    modal.style.display = "none";
                }
            });
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
        const userMenu = document.querySelector(".user-menu");
        const userMenuBtn = userMenu?.querySelector("a");

        if (userMenu && userMenuBtn) {
            userMenuBtn.addEventListener("click", (e) => {
            e.preventDefault();
            e.stopPropagation();
            userMenu.classList.toggle("active");
            });

            // Evita que se cierre al hacer clic dentro del menú
            userMenu.querySelector(".dropdown").addEventListener("click", (e) => e.stopPropagation());

            // Cierra el menú al hacer clic fuera
            document.addEventListener("click", (e) => {
            if (!userMenu.contains(e.target)) {
                userMenu.classList.remove("active");
            }
            });
        }
        });
    </script>
</body>
</html>