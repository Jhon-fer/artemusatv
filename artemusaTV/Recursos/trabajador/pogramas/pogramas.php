<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "artemusatvphp");

// Validar conexión
if ($conexion->connect_errno) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

session_start();

// Verificar sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: /Practicas/artemusaTV/app/views/login.php");
    exit();
}

// ====================
// CRUD: Añadir Programa
// ====================
if (isset($_POST['agregar'])) {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $canal = $conexion->real_escape_string($_POST['canal']);
    $hora_inicio = $conexion->real_escape_string($_POST['hora_inicio']);
    $hora_fin = $conexion->real_escape_string($_POST['hora_fin']);

    $sql_insert = "INSERT INTO programas (nombre, descripcion, canal, hora_inicio, hora_fin)
                   VALUES ('$nombre', '$descripcion', '$canal', '$hora_inicio', '$hora_fin')";
    $conexion->query($sql_insert);
    header("Location: pogramas.php");
    exit();
}

// ====================
// CRUD: Eliminar Programa
// ====================
if (isset($_GET['eliminar'])) {
    $id = (int) $_GET['eliminar'];
    $conexion->query("DELETE FROM programas WHERE id = $id");
    header("Location: pogramas.php");
    exit();
}

// ====================
// CRUD: Editar Programa
// ====================
if (isset($_POST['editar'])) {
    $id = (int) $_POST['id'];
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    $canal = $conexion->real_escape_string($_POST['canal']);
    $hora_inicio = $conexion->real_escape_string($_POST['hora_inicio']);
    $hora_fin = $conexion->real_escape_string($_POST['hora_fin']);

    $sql_update = "UPDATE programas 
                   SET nombre='$nombre', descripcion='$descripcion', canal='$canal', hora_inicio='$hora_inicio', hora_fin='$hora_fin' 
                   WHERE id=$id";
    $conexion->query($sql_update);
    header("Location: pogramas.php");
    exit();
}

// ====================
// Consulta de programas
// ====================
$sql = "SELECT id, nombre, descripcion, canal,
               CONCAT(DATE_FORMAT(hora_inicio, '%h:%i %p'), ' - ', DATE_FORMAT(hora_fin, '%h:%i %p')) AS horario,
               hora_inicio, hora_fin
        FROM programas
        ORDER BY id ASC";

$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>📺 Programación de Hoy</title>
    <link rel="stylesheet" href="css/styleP.css?v=1.0">
    <link rel="icon" href="../img/ixon.jpg">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="../img/baner.jpg" alt="Logo Artemusa TV">
            <span>ARTEMUSA TV</span>
        </div>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="pogramas.php">Programas</a></li>
            <li><a href="../pogramasN/index.php">Noticias</a></li>
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

    <h1>📺 Programación de Hoy</h1>

    <!-- Botón que abre el formulario -->
    <button class="btn-open" onclick="openForm()">➕ Agregar Programa</button>

    <!-- Formulario flotante (modal) -->
    <div id="formModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeForm()">&times;</span>
            <h2>➕ Agregar Programa</h2>
            <form method="POST">
                <input type="text" name="nombre" placeholder="Nombre del programa" required>
                <input type="text" name="descripcion" placeholder="Descripción" required>
                <input type="text" name="canal" placeholder="Canal" required>
                
                <label>Hora Inicio:</label>
                <input type="time" name="hora_inicio" required>
                
                <label>Hora Fin:</label>
                <input type="time" name="hora_fin" required>
                
                <button type="submit" name="agregar" class="btn-submit">✅ Agregar</button>
            </form>
        </div>
    </div>

    <!-- Tabla de Programación -->
    <table>
        <tr>
            <th>ID</th>
            <th>Programa</th>
            <th>Descripción</th>
            <th>Horario</th>
            <th>Canal</th>
            <th>Acciones</th>
        </tr>
        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <?php while($fila = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['nombre']) ?></td>
                    <td><?= htmlspecialchars($fila['descripcion']) ?></td>
                    <td><?= htmlspecialchars($fila['horario']) ?></td>
                    <td><?= htmlspecialchars($fila['canal']) ?></td>
                    <td>
                        <!-- Botón para abrir modal de edición -->
                        <button type="button" class="btn-edit" 
                            onclick="abrirModalEditar(
                                '<?= $fila['id'] ?>',
                                '<?= htmlspecialchars($fila['nombre'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($fila['descripcion'], ENT_QUOTES) ?>',
                                '<?= htmlspecialchars($fila['canal'], ENT_QUOTES) ?>',
                                '<?= $fila['hora_inicio'] ?>',
                                '<?= $fila['hora_fin'] ?>'
                            )">
                            ✏ Editar
                        </button>

                        <!-- Botón eliminar -->
                        <a href="?eliminar=<?= $fila['id'] ?>" class="btn-delete" 
                        onclick="return confirm('¿Seguro que deseas eliminar este programa?')">
                        🗑 Eliminar
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td class="no-data" colspan="6">📌 No hay programación disponible</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Modal Editar -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModalEditar()">&times;</span>
            <h2>✏ Editar Programa</h2>
            <form method="POST">
                <input type="hidden" name="id" id="edit-id">

                <label>Nombre:</label>
                <input type="text" name="nombre" id="edit-nombre" required>

                <label>Descripción:</label>
                <input type="text" name="descripcion" id="edit-descripcion" required>

                <label>Canal:</label>
                <input type="text" name="canal" id="edit-canal" required>

                <label>Hora Inicio:</label>
                <input type="time" name="hora_inicio" id="edit-hora-inicio" required>

                <label>Hora Fin:</label>
                <input type="time" name="hora_fin" id="edit-hora-fin" required>

                <button type="submit" name="editar" class="btn-submit">Guardar Cambios</button>
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
    function openForm() {
        document.getElementById("formModal").style.display = "block";
    }
    function closeForm() {
        document.getElementById("formModal").style.display = "none";
    }
    // Cierra el modal si se hace clic fuera del contenido
    window.onclick = function(event) {
        if (event.target == document.getElementById("formModal")) {
            closeForm();
        }
    }
    </script>

    <script>
    function abrirModalEditar(id, nombre, descripcion, canal, hora_inicio, hora_fin) {
        document.getElementById("modalEditar").style.display = "block";
        document.getElementById("edit-id").value = id;
        document.getElementById("edit-nombre").value = nombre;
        document.getElementById("edit-descripcion").value = descripcion;
        document.getElementById("edit-canal").value = canal;
        document.getElementById("edit-hora-inicio").value = hora_inicio;
        document.getElementById("edit-hora-fin").value = hora_fin;
    }

    function cerrarModalEditar() {
        document.getElementById("modalEditar").style.display = "none";
    }

    // Cerrar modal si se hace clic fuera
    window.onclick = function(event) {
        let modal = document.getElementById("modalEditar");
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

</body>
</html>
