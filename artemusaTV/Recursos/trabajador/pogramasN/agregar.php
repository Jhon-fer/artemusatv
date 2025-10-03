<?php
// 📌 Ruta absoluta al archivo JSON (siempre el mismo)
$archivo = __DIR__ . "/data/noticias.json";

// ✅ Crear carpeta de subidas si no existe
if (!is_dir(__DIR__ . "/uploads")) {
    mkdir(__DIR__ . "/uploads", 0777, true);
}

// ✅ Crear archivo JSON si no existe
if (!file_exists($archivo)) {
    file_put_contents($archivo, "[]");
}

$noticias = json_decode(file_get_contents($archivo), true);
if (!is_array($noticias)) {
    $noticias = [];
}

// ✅ Validar campos obligatorios
if (empty($_POST["titulo"]) || empty($_POST["contenido"]) || empty($_POST["autor"])) {
    echo "<script>
            alert('❌ Faltan datos obligatorios');
            window.history.back();
          </script>";
    exit;
}

// ✅ Procesar imagen (si existe)
$nombreImagen = "";
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $nombreImagen = "uploads/" . uniqid("img_") . "." . $ext;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], __DIR__ . "/" . $nombreImagen)) {
        echo "<script>
                alert('❌ Error al subir la imagen');
                window.history.back();
              </script>";
        exit;
    }
}

// ✅ Calcular ID único
$id = 1;
if (!empty($noticias)) {
    $ids = array_column($noticias, "id");
    $id = max($ids) + 1;
}

// ✅ Procesar enlace o ID de YouTube
$video = "";
if (!empty($_POST["video"])) {
    $videoInput = trim($_POST["video"]);

    // Caso 1: Enlace largo (ej: youtube.com/watch?v=ID)
    if (preg_match('/v=([a-zA-Z0-9_-]+)/', $videoInput, $matches)) {
        $video = $matches[1];
    }
    // Caso 2: Enlace corto (ej: youtu.be/ID)
    elseif (preg_match('#youtu\.be/([a-zA-Z0-9_-]+)#', $videoInput, $matches)) {
        $video = $matches[1];
    }
    // Caso 3: Shorts (ej: youtube.com/shorts/ID)
    elseif (preg_match('#shorts/([a-zA-Z0-9_-]+)#', $videoInput, $matches)) {
        $video = $matches[1];
    }
    // Caso 4: Directamente el ID
    else {
        $video = $videoInput;
    }
}

// ✅ Crear nueva noticia
$nueva = [
    "id"         => $id,
    "titulo"     => $_POST["titulo"],
    "autor"      => $_POST["autor"],
    "imagen"     => $nombreImagen,
    "contenido"  => $_POST["contenido"],
    "video"      => $video,
    "subtitulos" => array_filter($_POST["subtitulo"]),   // guarda solo los que tengan texto
    "comentarios"=> array_filter($_POST["comentario"]), // guarda solo los que tengan texto
    "fecha"      => date("Y-m-d H:i:s")
];

// ✅ Guardar en JSON
$noticias[] = $nueva;
file_put_contents($archivo, json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// ✅ Mostrar alerta y redirigir
echo "<script>
        alert('✅ Noticia guardada correctamente');
        window.location.replace('index.php?nocache=' + new Date().getTime());
      </script>";
exit;
?>
