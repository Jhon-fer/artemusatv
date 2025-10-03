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
    <title>ARTEMUSA TV</title>
    <style>
        /* 🔥 Estilos del modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background: rgba(0,0,0,0.6);
        }

        .modal-content {
            background: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 8px;
            width: 60%;
            max-width: 800px;
            text-align: left;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
        }

        .close {
            float: right;
            font-size: 22px;
            cursor: pointer;
        }

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
            flex-direction: column;
            opacity: 0;
            transform: translateY(-10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .user-menu .dropdown li {
            color: #fff;
            font-size: 0.9rem;
            margin: 6px 0;
        }

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

        .user-menu:hover .dropdown {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        /* Estilos de la noticia */
        .noticia-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .noticia-card img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .noticia-card h3 {
            margin: 0 0 10px;
        }

        .noticia-card button {
            background: #ff4c4c;
            color: #fff;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .noticia-card button:hover {
            background: #e03e3e;
        }
    </style>
</head>
<body>
    <!-- NAV -->
    <nav class="navbar">
         <div class="nav-left">
            <img src="..\img\nuevo logo011.png" alt="iconA" class="nav-banner">
            <a href="..index.php" class="logo">ARTEMUSA TV</a>
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
            <li><a href="../informacion/informacion.php">Informacion</a></li>
            <li><a href="../contacto/contacto.php">Contacto</a></li>
            <!-- Menú de usuario -->
            <li class="user-menu">
                <a><?= $_SESSION['usuario'] ?? 'Invitado' ?> ⬇</a>
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
        <!-- Botones -->
        <button id="abrirFormulario">➕ Agregar Noticia</button>
        <button id="abrirEliminar">🗑️ Eliminar Noticia</button>
        
        <div id="contenedor-noticias"></div>
    </section>


    <!-- Ventana flotante (oculta por defecto) -->
    <div id="modalFormulario" class="modal">
        <div class="modal-contenido">
            <span id="cerrarFormulario" class="cerrar">&times;</span>
            <h2>Agregar Noticia</h2>
            <form id="form-noticia" action="agregar.php" method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="titulo">Título *</label>
                    <input type="text" id="titulo" name="titulo" required>
                </div>

                <div class="form-group">
                    <label for="autor">Autor de la noticia *</label>
                    <input type="text" id="autor" name="autor" required>
                </div>

                <div class="form-group">
                    <label for="imagen">Subir Imagen *</label>
                    <input type="file" id="imagen" name="imagen" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="contenido">Contenido *</label>
                    <textarea id="contenido" name="contenido" required></textarea>
                </div>

                <div class="form-group">
                    <label for="video">Enlace o ID de YouTube</label>
                    <input type="text" id="video" name="video" placeholder="Ejemplo: https://www.youtube.com/watch?v=MKMMTNu9ePg">
                </div>

                <!-- Primer par (OBLIGATORIO) -->
                <div class="form-group">
                    <label for="subtitulo1">Gorrito *</label>
                    <input type="text" id="subtitulo1" name="subtitulo[]" required>
                </div>

                <div class="form-group">
                    <label for="comentario1">Comentario *</label>
                    <textarea id="comentario1" name="comentario[]" required></textarea>
                </div>

                <!-- Segundo par (OPCIONAL) -->
                <div class="form-group">
                    <label for="subtitulo2">Gorrito 2 (opcional)</label>
                    <input type="text" id="subtitulo2" name="subtitulo[]">
                </div>

                <div class="form-group">
                    <label for="comentario2">Comentario 2 (opcional)</label>
                    <textarea id="comentario2" name="comentario[]"></textarea>
                </div>

                <!-- Tercer par (OPCIONAL) -->
                <div class="form-group">
                    <label for="subtitulo3">Gorrito 3 (opcional)</label>
                    <input type="text" id="subtitulo3" name="subtitulo[]">
                </div>

                <div class="form-group">
                    <label for="comentario3">Comentario 3 (opcional)</label>
                    <textarea id="comentario3" name="comentario[]"></textarea>
                </div>

                <button type="submit">Guardar Noticia</button>
            </form>
        </div>
    </div>

    <!-- 🔥 Modal para ver noticia -->
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <img id="modal-img" src="" alt="Imagen noticia">
            <h3 id="modal-title"></h3>
            <p id="modal-desc"></p>
            <div id="modal-video"></div>
        </div>
    </div>

    <!-- Modal para eliminar noticia -->
    <div id="modalEliminar" class="modal">
        <div class="modal-contenido">
            <span id="cerrarEliminar" class="cerrar">&times;</span>
            <h2>Eliminar Noticia</h2>
            
            <form id="form-eliminar" action="eliminar.php" method="POST">
            <div class="form-group">
                <label for="noticiaId">Selecciona una noticia:</label>
                <select id="noticiaId" name="id" required>
                <!-- Noticias se cargarán aquí con JS -->
                </select>
            </div>
            <button type="submit" style="background:red; color:#fff;">Eliminar</button>
            </form>
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
                <li><a href="https://www.facebook.com/artemusatelevision" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                <li><a href="https://www.youtube.com/@artemusatelevision" target="_blank"><i class="fab fa-youtube"></i> YouTube</a></li>
                <li><a href="https://www.tiktok.com/@artemusa_tv" target="_blank"><i class="fab fa-tiktok"></i> TikTok</a></li>
            </ul>
        </div>
    </div>

    <script>
    async function cargarNoticias() {
        try {
            const response = await fetch("data/noticias.json");
            const noticias = await response.json();

            const contenedor = document.getElementById("contenedor-noticias");
            contenedor.innerHTML = "";

            // Ordenar por fecha (más recientes primero)
            noticias.sort((a, b) => new Date(b.fecha) - new Date(a.fecha));

            noticias.forEach(noticia => {
                const card = document.createElement("div");
                card.classList.add("noticia-card");

                card.innerHTML = `
                    <h3>${noticia.titulo}</h3>
                    <img src="${noticia.imagen}" alt="${noticia.titulo}">
                    <p>${noticia.contenido.substring(0,120)}...</p>
                    <a href="noticias.php?id=${noticia.id}">
                        <button>Leer más ➡</button>
                    </a>
                `;

                contenedor.appendChild(card);
            });
        } catch (error) {
            console.error("Error al cargar noticias:", error);
        }
    }

    function openModal(imagen, titulo, descripcion, video) {
        document.getElementById("newsModal").style.display = "block";
        document.getElementById("modal-img").src = imagen;
        document.getElementById("modal-title").innerText = titulo;
        document.getElementById("modal-desc").innerText = descripcion;

        let videoContainer = document.getElementById("modal-video");
        if (video) {
            videoContainer.innerHTML = `
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/${video}"
              frameborder="0" allowfullscreen></iframe>`;
        } else {
            videoContainer.innerHTML = "";
        }
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
        // Abrir y cerrar modal
        const modal = document.getElementById("modalFormulario");
        const abrirBtn = document.getElementById("abrirFormulario");
        const cerrarBtn = document.getElementById("cerrarFormulario");

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
    </script>

    <script>
        // Modal Eliminar
        const modalEliminar = document.getElementById("modalEliminar");
        const abrirEliminar = document.getElementById("abrirEliminar");
        const cerrarEliminar = document.getElementById("cerrarEliminar");
        const selectNoticias = document.getElementById("noticiaId");

        // Abrir modal y cargar noticias
        abrirEliminar.onclick = async function() {
            modalEliminar.style.display = "block";

            try {
                const response = await fetch("data/noticias.json");
                const noticias = await response.json();

                // Limpiar el select
                selectNoticias.innerHTML = "";

                // Agregar opciones con id y título
                noticias.forEach(noticia => {
                    let option = document.createElement("option");
                    option.value = noticia.id;
                    option.textContent = `${noticia.id} - ${noticia.titulo}`;
                    selectNoticias.appendChild(option);
                });
            } catch (error) {
                console.error("Error al cargar noticias:", error);
            }
        };

        // Cerrar modal
        cerrarEliminar.onclick = function() {
            modalEliminar.style.display = "none";
        };
    </script>
</body>
</html>
