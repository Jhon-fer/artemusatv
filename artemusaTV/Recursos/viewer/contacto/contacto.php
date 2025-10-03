<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: /Practicas/artemusaTV/app/views/login.php");
    exit();
}

$conexion = new mysqli("localhost", "root", "", "artemusatvphp");
if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 🔹 Insertar comentario si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensaje'])) {
    $nombre = $_SESSION['usuario'] ?? 'Usuario';
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

    <h2>💬 Comentarios de la Comunidad</h2>

    <!-- Formulario para nuevo comentario -->
    <form method="POST">
        <textarea name="mensaje" rows="3" placeholder="Escribe tu comentario..." required></textarea>
        <button type="submit">Comentar</button>
    </form>

    <!-- Lista de comentarios -->
    <div class="comentarios">
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while($row = $resultado->fetch_assoc()): ?>
                <div class="comentario">
                    <p><strong><?= htmlspecialchars($row['nombre']) ?>:</strong> <?= nl2br(htmlspecialchars($row['mensaje'])) ?></p>
                    <small>📅 <?= $row['fecha'] ?></small>

                    <!-- Respuestas del trabajador -->
                    <?php if (!empty($respuestas[$row['id']])): ?>
                        <?php foreach ($respuestas[$row['id']] as $resp): ?>
                            <div class="respuesta">
                                <p><strong><?= htmlspecialchars($resp['trabajador']) ?> (staff):</strong> <?= nl2br(htmlspecialchars($resp['respuesta'])) ?></p>
                                <small>📅 <?= $resp['fecha'] ?></small>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="text-align:center;">No hay comentarios aún. ¡Sé el primero en comentar! 🚀</p>
        <?php endif; ?>
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
</body>
</html>
