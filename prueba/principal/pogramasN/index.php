<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../img/ixon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>ARTEMUSA TV</title>
</head>
<body>
    <nav>
        <a href="#" class="logo">ARTEMUSA TV</a>
        <img src="../img/baner.jpg" alt="iconA">
        <span class="menu-toggle">☰</span>
        <ul>
            <li><a href="../index.phpl">Inicio</a></li>
            <li><a href="#">Programas</a></li>
            <li><a href="pogramas/index.html">Noticias</a></li>
            <li><a href="#">Servicio</a></li>
            <li><a href="#">Informacion</a></li>
            <li><a href="#">Contacto</a></li>
        </ul>
    </nav>

    <!-- Sección Noticias -->
    <section class="noticias">
        <h2>Últimas Noticias</h2>

        <div class="news-grid">
            <!-- Card Noticia 1 -->
            <article class="news-card" onclick="openModal('img/ixon.jpg', 'Título Noticia 1', 'Descripción breve de la noticia 1...')">
                <img src="img/baner.jpg" alt="Imagen de la noticia 1">
                <h3>Título Noticia 1</h3>
                <p>Descripción breve de la noticia 1...</p>
            </article>

            <!-- Card Noticia 2 -->
            <article class="news-card" onclick="openModal('img/noticia2.jpg', 'Título Noticia 2', 'Descripción breve de la noticia 2...')">
                <img src="img/noticia2.jpg" alt="Imagen de la noticia 2">
                <h3>Título Noticia 2</h3>
                <p>Descripción breve de la noticia 2...</p>
            </article>

            <!-- Card Noticia 3 -->
            <article class="news-card" onclick="openModal('img/noticia3.jpg', 'Título Noticia 3', 'Descripción breve de la noticia 3...')">
                <img src="img/noticia3.jpg" alt="Imagen de la noticia 3">
                <h3>Título Noticia 3</h3>
                <p>Descripción breve de la noticia 3...</p>
            </article>
        </div>
    </section>

    <!-- Modal para noticias -->
    <div id="newsModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modal-img" alt="Imagen de la noticia ampliada">
        <div class="modal-caption">
            <h3 id="modal-title"></h3>
            <p id="modal-desc"></p>
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
    <script src="js/abrir.js"></script>
</body>
</html>