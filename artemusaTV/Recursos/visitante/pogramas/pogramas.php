<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "artemusatvphp");

// Validar conexión
if ($conexion->connect_errno) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

session_start();

// ====================
// Consulta de programas
// ====================
$sql = "SELECT id, nombre, descripcion, canal,
               CONCAT(DATE_FORMAT(hora_inicio, '%h:%i %p'), ' - ', DATE_FORMAT(hora_fin, '%h:%i %p')) AS horario
        FROM programas
        ORDER BY hora_inicio ASC";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📺 Programación de Hoy</title>
    <link rel="stylesheet" href="css/styleP.css">
    <link rel="stylesheet" href="../estiloCelular.css">
    <link rel="icon" href="../img/ixon.jpg">
</head>
<body>
    <!-- NAV (versión Noticias que sí funciona) -->
    <nav class="navbar">
        <div class="nav-left">
            <img src="../img/nuevo logo011.png" alt="iconA" class="nav-banner">
            <a href="../index.php" class="logo">ARTEMUSA TV</a>
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

        <!-- Menú de enlaces -->
        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
            <li><a href="../candelaria/candelaria.php">Soy Candelaria</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="../informacion/informacion.php">Información</a></li>
            <li><a href="../contacto/contacto.php">Contacto</a></li>
            <li><a href="/Practicas/artemusaTV/app/views/login.php">Iniciar sesión</a></li>
        </ul>
    </nav>

    <h1>📺 Programación de Hoy</h1>

    <!-- Tabla de Programación -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Programa</th>
                <th>Descripción</th>
                <th>Horario</th>
                <th>Canal</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while($fila = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td data-label="ID"><?= $fila['id'] ?></td>
                        <td data-label="Programa"><?= htmlspecialchars($fila['nombre']) ?></td>
                        <td data-label="Descripción"><?= htmlspecialchars($fila['descripcion']) ?></td>
                        <td data-label="Horario"><?= htmlspecialchars($fila['horario']) ?></td>
                        <td data-label="Canal"><?= htmlspecialchars($fila['canal']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td class="no-data" colspan="5">📌 No hay programación disponible</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
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
