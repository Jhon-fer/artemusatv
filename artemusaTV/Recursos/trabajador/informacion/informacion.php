<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /Practicas/artemusaTV/app/views/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ARTEMUSA TV</title>
    <link rel="icon" href="../img/ixon.jpg">
    <link rel="stylesheet" href="css/style.css?v=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
    <nav>
        <div style="display: flex; align-items: center; gap:10px;">
            <span class="logo">ARTEMUSA TV</span>
            <img src="../img/baner.jpg" alt="banner">
        </div>

        <ul>
            <li><a href="../index.php"></i> Inicio</a></li>
            <li><a href="../pogramas/pogramas.php"></i> Programas</a></li>
            <li><a href="../pogramasN/index.php"></i> Noticias</a></li>
            <li><a href="informacion.php"></i> Información</a></li>
            <li><a href="../contacto/contacto.php"></i> Contacto</a></li>

            <!-- Menú de usuario -->
            <li class="user-menu">
                <a><i class="fa fa-user-circle"></i> <?= $_SESSION['usuario'] ?? 'Invitado' ?> ⬇</a>
                <ul class="dropdown">
                    <li><strong>Correo:</strong> <?= $_SESSION['correo'] ?? 'No definido' ?></li>
                    <li><strong>Rol:</strong> <?= $_SESSION['rol'] ?? 'Usuario' ?></li>
                    <li><a href="../../../public/logout.php"><i class="fa fa-sign-out-alt"></i> Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <main style="padding: 30px; max-width: 1200px; margin: auto; color: #333;">

        <!-- Sobre Nosotros -->
        <section style="margin-bottom: 40px;">
            <h1>Sobre ArtemusaTV</h1>
            <p>
                ArtemusaTV es un canal de televisión local de Puno que transmite noticias, 
                programas culturales, entretenimiento y cobertura de eventos importantes. 
                Nuestro compromiso es informar, educar y entretener a la comunidad puneña 
                con contenidos de calidad y producción local.
            </p>
        </section>

        <!-- Misión y Visión -->
        <section style="margin-bottom: 40px;">
            <h2>Misión</h2>
            <p>
                Brindar un servicio televisivo de calidad que refleje la identidad cultural 
                de Puno y sirva como medio de comunicación accesible para todos.
            </p>
            <h2>Visión</h2>
            <p>
                Convertirnos en el canal líder de la región sur del Perú, expandiendo 
                nuestra señal a nivel nacional e internacional.
            </p>
        </section>

        <!-- galeria de imagenes -->
        <section class="galeria">
            <h2>Galería de Imágenes</h2>
            <div class="contenedor-galeria">
                <div class="imagen">
                    <img src="../img/baner.jpg" alt="Foto 1" onclick="abrirModal(this)">
                </div>
                <div class="imagen">
                    <img src="../img/ixon.jpg" alt="Foto 2" onclick="abrirModal(this)">
                </div>
                <div class="imagen">
                    <img src="../img/" alt="Foto 3" onclick="abrirModal(this)">
                </div>
                <div class="imagen">
                    <img src="imagenes/foto4.jpg" alt="Foto 4" onclick="abrirModal(this)">
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div id="modal" class="modal">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <img class="modal-contenido" id="imagen-ampliada">
            <div id="caption"></div>
        </div>

        <!-- Ubicación con Google Maps -->
        <section style="margin-bottom: 40px;">
            <h2>Ubícanos</h2>
            <p>Nuestra sede se encuentra en Puno, Perú.</p>
            <div style="margin-top:20px;">
                <h3 style="color:#333; font-weight:bold;">📍 Encuéntranos en Puno</h3>
                <iframe 
                    src="https://maps.google.com/maps?q=-15.840836579931862,-70.02654643428384&hl=es&z=18&t=k&output=embed" 
                    width="100%" 
                    height="300" 
                    style="border:0; border-radius:10px;" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </section>

        <!-- Redes Sociales -->
        <section style="margin-bottom: 40px;">
            <h2>Síguenos en Redes Sociales</h2>
            <div style="display:flex; gap:20px; align-items:center;">
                <a href="https://www.facebook.com/artemusatelevision" target="_blank">
                    <i class="fab fa-facebook fa-2x" style="color:#1877f2;"></i> Facebook
                </a>
                <a href="https://www.youtube.com/@artemusatelevision/featured" target="_blank">
                    <i class="fab fa-youtube fa-2x" style="color:#ff0000;"></i> YouTube
                </a>
                <a href="https://www.tiktok.com/@artemusa_tv" target="_blank">
                    <i class="fab fa-tiktok fa-2x" style="color:#000;"></i> TikTok
                </a>
            </div>
        </section>

        <!-- Contacto -->
        <section>
            <h2>Contacto</h2>
            <p><i class="fa fa-phone"></i> Teléfono: +51 900 000 000</p>
            <p><i class="fa fa-envelope"></i> Correo: contacto@artemusatv.com</p>
        </section>
    </main>

    <script>
    let indiceActual = 0;
    let imagenes = [];

    function abrirModal(img) {
        imagenes = document.querySelectorAll(".contenedor-galeria img");
        indiceActual = Array.from(imagenes).indexOf(img);

        mostrarImagen(indiceActual);
        document.getElementById("modal").style.display = "block";
    }

    function mostrarImagen(indice) {
        let img = imagenes[indice];
        document.getElementById("imagen-ampliada").src = img.src;
        document.getElementById("caption").innerHTML = img.alt;
    }

    function cerrarModal() {
        document.getElementById("modal").style.display = "none";
    }

    function cambiarImagen(direccion) {
        indiceActual += direccion;

        if (indiceActual < 0) {
            indiceActual = imagenes.length - 1;
        } else if (indiceActual >= imagenes.length) {
            indiceActual = 0;
        }

        mostrarImagen(indiceActual);
    }

    // Cerrar con la tecla ESC o clic fuera de la imagen
    document.addEventListener("keydown", function(e) {
        if (e.key === "Escape") {
            cerrarModal();
        } else if (e.key === "ArrowRight") {
            cambiarImagen(1);
        } else if (e.key === "ArrowLeft") {
            cambiarImagen(-1);
        }
    });

    document.getElementById("modal").addEventListener("click", function(e) {
        if (e.target.id === "modal") {
            cerrarModal();
        }
    });
    </script>
</body>
</html>
