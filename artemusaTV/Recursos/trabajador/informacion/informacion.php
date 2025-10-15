<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /app/views/login.php");
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
    <nav class="navbar">
        <div class="nav-left">
            <img src="../img/nuevo logo011.png" alt="iconA" class="nav-banner">
            <a href="../index.php" class="logo">ARTEMUSA TV</a>
            <button class="menu-toggle" id="menu-toggle">☰</button>
        </div>

        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
            <li><a href="../candelaria/candelaria.php">Soy Candelaria</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="informacion.php" class="active">Información</a></li>
            <li><a href="../contacto/contacto.php">Contacto</a></li>

            <!-- Menú de usuario -->
            <li class="user-menu">
                <a href="#" id="user-toggle">
                    <i class="fa fa-user-circle"></i>
                    <?= htmlspecialchars($_SESSION['usuario'] ?? 'Invitado') ?> ⬇
                </a>
                <ul class="dropdown" id="user-dropdown">
                    <li><strong>Correo:</strong> <?= htmlspecialchars($_SESSION['correo'] ?? 'No definido') ?></li>
                    <li><strong>Rol:</strong> <?= htmlspecialchars($_SESSION['rol'] ?? 'viewer') ?></li>
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

        <!-- Galería de Imágenes -->
        <section class="galeria">
            <h2>Galería de Imágenes</h2>
            <div class="contenedor-galeria">
                <div class="imagen"><img src="../img/baner.jpg" alt="Foto 1" onclick="abrirModal(this)"></div>
                <div class="imagen"><img src="../img/ixon.jpg" alt="Foto 2" onclick="abrirModal(this)"></div>
                <div class="imagen"><img src="../img/nuevo logo011.png" alt="Foto 3" onclick="abrirModal(this)"></div>
            </div>
        </section>

        <!-- Modal -->
        <div id="modal" class="modal">
            <span class="cerrar" onclick="cerrarModal()">&times;</span>
            <img class="modal-contenido" id="imagen-ampliada">
            <div id="caption"></div>
        </div>

        <!-- Ubicación -->
        <section style="margin-bottom: 40px;">
            <h2>Ubícanos</h2>
            <p>Nuestra sede se encuentra en Puno, Perú.</p>
            <div style="margin-top:20px;">
                <h3 style="color:#333; font-weight:bold;">📍 Encuéntranos en Puno</h3>
                <iframe 
                    src="https://maps.google.com/maps?q=-15.840836579931862,-70.02654643428384&hl=es&z=18&t=k&output=embed" 
                    width="100%" height="300" 
                    style="border:0; border-radius:10px;" 
                    allowfullscreen loading="lazy">
                </iframe>
            </div>
        </section>

        <!-- Redes Sociales -->
        <section style="margin-bottom: 40px;">
            <h2>Síguenos en Redes Sociales</h2>
            <div style="display:flex; gap:20px; align-items:center; flex-wrap:wrap;">
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
        // === Menú hamburguesa ===
        const toggle = document.getElementById("menu-toggle");
        const links = document.getElementById("nav-links");
        toggle.addEventListener("click", () => links.classList.toggle("active"));

        // === Menú del usuario ===
        const userToggle = document.getElementById("user-toggle");
        const userDropdown = document.getElementById("user-dropdown");

        userToggle.addEventListener("click", (e) => {
            e.preventDefault();
            userDropdown.classList.toggle("show");
        });

        document.addEventListener("click", (e) => {
            if (!userToggle.contains(e.target) && !userDropdown.contains(e.target)) {
                userDropdown.classList.remove("show");
            }
        });

        // === Galería ===
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

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") cerrarModal();
            else if (e.key === "ArrowRight") indiceActual = (indiceActual + 1) % imagenes.length, mostrarImagen(indiceActual);
            else if (e.key === "ArrowLeft") indiceActual = (indiceActual - 1 + imagenes.length) % imagenes.length, mostrarImagen(indiceActual);
        });

        document.getElementById("modal").addEventListener("click", (e) => {
            if (e.target.id === "modal") cerrarModal();
        });
    </script>
</body>
</html>
