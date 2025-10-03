<?php

$conexion = new mysqli("localhost", "root", "", "artemusatvphp");
if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 🔹 Insertar comentario solo si hay sesión activa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensaje']) && isset($_SESSION['usuario_id'])) {
    $nombre = $_SESSION['usuario']; // Ya tienes el usuario logueado
    $mensaje = $conexion->real_escape_string($_POST['mensaje']);
    $conexion->query("INSERT INTO comentarios (nombre, mensaje) VALUES ('$nombre', '$mensaje')");
}

// 🔹 Obtener comentarios con sus respuestas
$sql = "SELECT * FROM comentarios ORDER BY fecha DESC";
$resultado = $conexion->query($sql);

$respuestas_sql = "SELECT * FROM respuestas ORDER BY fecha ASC";
$respuestas_res = $conexion->query($respuestas_sql);
$respuestas = [];
while ($r = $respuestas_res->fetch_assoc()) {
    $respuestas[$r['comentario_id']][] = $r;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contacto.css">
    <link rel="icon" href="../img/ixon.jpg">
    <title>Comentarios | ARTEMUSA TV</title>
</head>
<body>

    <!-- NAV -->
    <nav>
        <div class="nav-left">
            <img src="../img/nuevo logo011.png" alt="iconA" class="nav-banner">
            <a href="../index.php" class="logo">ARTEMUSA TV</a>
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
            <li><a href="../candelaria/candelaria.php">Soy Candelaria</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="../informacion/informacion.php">Informacion</a></li>
            <li><a href="contacto.php">Contacto</a></li>
            <li><a href="/Practicas/artemusaTV/app/views/login.php">Iniciar sesión</a></li>
        </ul>
    </nav>

    <h2>💬 Comentarios de la Comunidad</h2>

    <?php

    // ✅ Mostrar formulario solo si está logeado
    if (isset($_SESSION['usuario_id'])): ?>
        <!-- Formulario para nuevo comentario -->
        <form method="POST" action="">
            <textarea name="mensaje" rows="3" placeholder="Escribe tu comentario..." required></textarea>
            <button type="submit" name="guardar_comentario">Comentar</button>
        </form>
    <?php else: ?>
        <!-- Aviso si no hay sesión -->
        <p style="color:red; font-weight:bold;">
            ⚠️ Debes <a href="/Practicas/artemusaTV/app/views/login.php">iniciar sesión</a> para escribir un comentario.
        </p>
    <?php endif; ?>

    <hr>

    <!-- Lista de comentarios -->
    <div class="comentarios">
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while($row = $resultado->fetch_assoc()): ?>
                <div class="comentario">
                    <p>
                        <strong><?= htmlspecialchars($row['nombre']) ?>:</strong> 
                        <?= nl2br(htmlspecialchars($row['mensaje'])) ?>
                    </p>
                    <small>📅 <?= htmlspecialchars($row['fecha']) ?></small>

                    <!-- Respuestas del trabajador -->
                    <?php if (!empty($respuestas[$row['id']])): ?>
                        <?php foreach ($respuestas[$row['id']] as $resp): ?>
                            <div class="respuesta">
                                <p>
                                    <strong><?= htmlspecialchars($resp['trabajador']) ?> (staff):</strong> 
                                    <?= nl2br(htmlspecialchars($resp['respuesta'])) ?>
                                </p>
                                <small>📅 <?= htmlspecialchars($resp['fecha']) ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No hay comentarios aún. ¡Sé el primero en comentar! 🚀</p>
        <?php endif; ?>

        <?php $conexion->close(); ?>
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
                Jr. Arequipa N° 255 con Jr. Cajamarca, Puno, Perú
            </a></p>
            <p>Horario: Lunes a Viernes 08:00 - 20:00</p>
        </div>
        <div class="footer-column">
            <h4>Síguenos</h4>
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/artemusatelevision" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-facebook-f"></i> Facebook
                </a></li>
                <li><a href="https://www.youtube.com/@artemusatelevision" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-youtube"></i> YouTube
                </a></li>
                <li><a href="https://www.tiktok.com/@artemusa_tv" target="_blank" rel="noopener noreferrer">
                    <i class="fab fa-tiktok"></i> TikTok
                </a></li>
            </ul>
        </div>
    </div>

    <script>
        // Esperamos que el DOM cargue
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById("menu-toggle");
            const navLinks = document.getElementById("nav-links");

            toggle.addEventListener("click", () => {
                navLinks.classList.toggle("active");
            });
        });
    </script>
</body>
</html>
