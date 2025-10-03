<?php
header("Content-Type: application/json");

$archivo = "data/noticias.json";

// ✅ Crear carpeta de subidas si no existe
if (!is_dir("uploads")) {
    mkdir("uploads", 0777, true);
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
    echo json_encode(["mensaje" => "❌ Faltan datos obligatorios"]);
    exit;
}

// ✅ Procesar imagen (si existe)
$nombreImagen = "";
if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES["imagen"]["name"], PATHINFO_EXTENSION);
    $nombreImagen = "uploads/" . uniqid("img_") . "." . $ext;

    if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreImagen)) {
        echo json_encode(["mensaje" => "❌ Error al subir la imagen"]);
        exit;
    }
}

// ✅ Calcular ID único
$id = 1;
if (!empty($noticias)) {
    $ids = array_column($noticias, "id");
    $id = max($ids) + 1;
}

// ✅ Crear nueva noticia
$nueva = [
    "id" => $id,
    "titulo" => $_POST["titulo"],
    "autor" => $_POST["autor"], // 👈 ahora sí se guarda el autor
    "imagen" => $nombreImagen,
    "contenido" => $_POST["contenido"],
    "video" => $_POST["video"] ?? "",
    "fecha" => date("Y-m-d H:i:s")
];

// ✅ Guardar en JSON
$noticias[] = $nueva;
file_put_contents($archivo, json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// ✅ Respuesta al cliente
echo json_encode([
    "mensaje" => "✅ Noticia guardada correctamente",
    "noticia" => $nueva
]);
