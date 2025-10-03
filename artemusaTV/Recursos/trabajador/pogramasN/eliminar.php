<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $idEliminar = (int) $_POST["id"];
    $archivo = "data/noticias.json";

    // Cargar noticias
    $noticias = json_decode(file_get_contents($archivo), true);

    // Filtrar quitando la noticia seleccionada
    $noticias = array_filter($noticias, function($n) use ($idEliminar) {
        return $n["id"] != $idEliminar;
    });

    // Reindexar array
    $noticias = array_values($noticias);

    // Guardar archivo actualizado
    file_put_contents($archivo, json_encode($noticias, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    header("Location: index.php"); // vuelve al listado
    exit();
}
?>
