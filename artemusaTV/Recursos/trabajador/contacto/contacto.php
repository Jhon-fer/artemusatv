<?php
session_start();

// 🔒 Verificar sesión activa
if (!isset($_SESSION['usuario'])) {
    header("Location: /app/views/login.php");
    exit();
}

// 🔹 Conexión a la base de datos
$conexion = new mysqli("localhost", "artemusa_artemusa", "7j4vV2mp5V", "artemusa_artemusatvphp");
if ($conexion->connect_errno) {
    die("Error de conexión: " . $conexion->connect_error);
}

// 🔹 Insertar respuesta si se envía el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comentario_id'], $_POST['respuesta'])) {
    $comentario_id = intval($_POST['comentario_id']);
    $respuesta = $conexion->real_escape_string($_POST['respuesta']);
    $trabajador = $conexion->real_escape_string($_SESSION['usuario'] ?? 'Trabajador');

    $conexion->query("INSERT INTO respuestas (comentario_id, trabajador, respuesta) 
                      VALUES ($comentario_id, '$trabajador', '$respuesta')");
}

// 🔹 Obtener comentarios
$sql = "SELECT * FROM comentarios ORDER BY fecha DESC";
$resultado = $conexion->query($sql);

// 🔹 Obtener respuestas asociadas
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
    <title>Comentarios | ARTEMUSA TV</title>
    <link rel="stylesheet" href="css/contacto.css">
    <link rel="icon" href="../img/ixon.jpg">
</head>
<body>

    <!-- NAV -->
    <nav>
        <div class="nav-left">
            <img src="../img/nuevo logo011.png" alt="logo" class="nav-banner">
            <a href="../index.php" class="logo">ARTEMUSA TV</a>
        </div>

        <!-- Botón hamburguesa -->
        <button class="menu-toggle" id="menu-toggle">☰</button>

        <ul class="nav-links" id="nav-links">
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="../pogramas/pogramas.php">Programas</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
            <li><a href="../informacion/informacion.php">Información</a></li>
            <li><a href="contacto.php" class="active">Contacto</a></li>

            <!-- Menú de usuario -->
            <li class="user-menu">
                <a><?= htmlspecialchars($_SESSION['usuario'] ?? 'viewer') ?> ⬇</a>
                <ul class="dropdown">
                    <li>Correo: <?= htmlspecialchars($_SESSION['correo'] ?? '') ?></li>
                    <li>Rol: <?= htmlspecialchars($_SESSION['rol'] ?? '') ?></li>
                    <li><a href="/public/logout.php">Cerrar sesión</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <h2 style="text-align:center;">📋 Comentarios de Usuarios</h2>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Mensaje</th>
                <th>Fecha</th>
                <th>Responder</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td data-label="Nombre"><?= htmlspecialchars($row['nombre']) ?></td>
                        <td data-label="Mensaje">
                            <?= nl2br(htmlspecialchars($row['mensaje'])) ?>
                            <?php if (!empty($respuestas[$row['id']])): ?>
                                <div class="respuestas">
                                    <?php foreach ($respuestas[$row['id']] as $resp): ?>
                                        <p><strong><?= htmlspecialchars($resp['trabajador']) ?>:</strong>
                                        <?= nl2br(htmlspecialchars($resp['respuesta'])) ?>
                                        <em>(<?= $resp['fecha'] ?>)</em></p>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td data-label="Fecha"><?= $row['fecha'] ?></td>
                        <td data-label="Responder">
                            <form method="POST" class="respuesta-form">
                                <input type="hidden" name="comentario_id" value="<?= $row['id'] ?>">
                                <textarea name="respuesta" rows="2" placeholder="Escribe tu respuesta..." required></textarea>
                                <button type="submit">Responder</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">No hay comentarios registrados.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-column">
            <p>© 2025 ARTEMUSA TV<br>Todos los derechos reservados</p>
        </div>
        <div class="footer-column">
            <p>Contacto: <a href="mailto:contacto@artemusatv.pe">contacto@artemusatv.pe</a></p>
            <p>Tel: <a href="tel:123456789">123-456-789</a></p>
            <p>Ubicación: <a href="https://www.google.com/maps/place/Jr.+Cutimbo+285,+Puno,+Perú" target="_blank">Jr. Cutimbo 285, Puno, Perú</a></p>
            <p>Horario: Lunes a Viernes 08:00 - 20:00</p>
        </div>
        <div class="footer-column">
            <h4>Síguenos</h4>
            <ul class="social-icons">
                <li><a href="https://www.facebook.com/artemusatelevision" target="_blank">Facebook</a></li>
                <li><a href="https://www.youtube.com/@artemusatelevision" target="_blank">YouTube</a></li>
                <li><a href="https://www.tiktok.com/@artemusa_tv" target="_blank">TikTok</a></li>
            </ul>
        </div>
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const toggle = document.getElementById("menu-toggle");
            const navLinks = document.getElementById("nav-links");
            toggle.addEventListener("click", () => navLinks.classList.toggle("active"));
        });
    </script>
</body>
</html>
