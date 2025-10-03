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
    <link rel="icon" href="../img/ixon.jpg">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>ARTEMUSA TV - Noticias</title>
</head>
<body>
    <nav>
        <div class="nav-left">
            <a href="../index.php" class="logo">ARTEMUSA TV</a>
            <img src="../img/baner.jpg" alt="iconA" class="nav-banner">
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="pogramasN/index.php">Noticias</a></li>
            <li><a href="../candelaria/candelaria.php">Soy Candelaria</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="../informacion/informacion.php">Informacion</a></li>
            <li><a href="../contacto/contacto.php">Contacto</a></li>

            <!-- Menú de usuario -->
            <li class="user-menu">
                <a>
                    <?= $_SESSION['usuario'] ?? 'Invitado' ?> ⬇
                </a>
                <ul class="dropdown">
                    <li>Correo: <?= $_SESSION['correo'] ?? '' ?></li>
                    <li>Rol: <?= $_SESSION['rol'] ?? '' ?></li>
                    <li><a href="../../../public/logout.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Sección Noticias -->
    <section id="lista-noticias">
        <h2>Últimas Noticias</h2>
        <div id="contenedor-noticias"></div>
    </section>

    <!-- 🔥 Modal para ver noticia -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modal-img" src="" alt="Imagen noticia" style="width:100%;max-height:300px;object-fit:cover;">
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

    <script>
        async function cargarNoticias() {
            try {
                const response = await fetch("../../trabajador/pogramasN/data/noticias.json");
                const noticias = await response.json();

                const contenedor = document.getElementById("contenedor-noticias");
                contenedor.innerHTML = "";

                // Ordenar por fecha (más recientes primero)
                    noticias.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

                noticias.forEach(noticia => {
                    const card = document.createElement("div");
                    card.classList.add("noticia-card");

                    // Ajustar ruta de imagen (si no es absoluta)
                    let imagen = noticia.imagen;
                    if (imagen && !imagen.startsWith("http")) {
                        imagen = "../../trabajador/pogramasN/" + imagen.replace(/^\/+/, "");
                    }

                    card.innerHTML = `
                        <h3>${noticia.titulo}</h3>
                        <img src="${imagen}" alt="${noticia.titulo}">
                        <p>${noticia.contenido.substring(0,120)}...</p>
                        <a href="noticias.php?id=${noticia.id}" class="btn-ver-mas">Leer más ➡</a>
                    `;

                    contenedor.appendChild(card);
                });
            } catch (error) {
                console.error("Error al cargar noticias:", error);
            }
        }

        function openModal(imagen, titulo, descripcion) {
            document.getElementById("newsModal").style.display = "block";
            document.getElementById("modal-img").src = imagen;
            document.getElementById("modal-title").innerText = titulo;
            document.getElementById("modal-desc").innerText = descripcion;
        }

        function closeModal() {
            document.getElementById("newsModal").style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = "none";
            }
        }

        // 🚀 Cargar noticias al iniciar
        cargarNoticias();
    </script>

    <script>
        // Abrir y cerrar modal de formulario (si existe en esta página)
        const modal = document.getElementById("modalFormulario");
        const abrirBtn = document.getElementById("abrirFormulario");
        const cerrarBtn = document.getElementById("cerrarFormulario");

        if (abrirBtn && cerrarBtn && modal) {
            abrirBtn.onclick = function() {
                modal.style.display = "block";
            }
            cerrarBtn.onclick = function() {
                modal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>
</body>
</html>
