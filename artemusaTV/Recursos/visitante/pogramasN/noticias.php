<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="../img/ixon.jpg">
  <title>Sitio de Noticias</title>
  <link rel="stylesheet" href="css/noticias.css">
</head>
<body>
  <div class="container">
    <nav>
      <a class="logo">ARTEMUSA TV</a>
      <img src="../img/baner.jpg" alt="iconA">
    </nav>

    <h1>📰 Detalle de Noticia</h1>
    <p><a href="index.php" class="boton">⬅ Volver al inicio</a></p>
    
    <div id="noticia"></div>
  </div>
  
  <script>
    // Obtener ID de la URL (ej: noticias.php?id=3)
    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");

    // Función para extraer el ID de un enlace de YouTube
    function getYoutubeId(url) {
      try {
        if (url.includes("youtube.com/watch?v=")) {
          const params = new URL(url).searchParams;
          return params.get("v");
        } else if (url.includes("youtu.be/")) {
          return url.split("youtu.be/")[1];
        } else {
          // Si ya solo guardaste el ID
          return url;
        }
      } catch {
        return "";
      }
    }

    if (!id) {
      document.getElementById("noticia").innerHTML = "<p>❌ No se encontró la noticia.</p>";
    } else {
      fetch("/Practicas/artemusaTV/Recursos/trabajador/pogramasN/data/noticias.json")
        .then(res => res.json())
        .then(noticias => {
          const noticia = noticias.find(n => n.id == id);
          if (!noticia) {
            document.getElementById("noticia").innerHTML = "<p>❌ Noticia no encontrada.</p>";
            return;
          }

          // Obtener ID del video (si existe)
          const videoId = noticia.video ? getYoutubeId(noticia.video) : "";

          // ✅ Ajustar ruta de la imagen (si no es absoluta)
          let imagen = noticia.imagen;
          if (imagen && !imagen.startsWith("http")) {
            imagen = "/Practicas/artemusaTV/Recursos/trabajador/pogramasN/" + imagen.replace(/^\/+/, "");
          }

          // Subtítulos y comentarios
          let subtitulosHtml = "";
          if (Array.isArray(noticia.subtitulos) && Array.isArray(noticia.comentarios)) {
            noticia.subtitulos.forEach((sub, i) => {
              let com = noticia.comentarios[i] ?? "";
              subtitulosHtml += `
                <h3>${sub}</h3>
                <p>${com}</p>
              `;
            });
          }

          // Renderizar noticia completa
          document.getElementById("noticia").innerHTML = `
            <h2>${noticia.titulo}</h2>
            ${imagen ? `<img src="${imagen}" alt="Imagen de noticia" style="max-width:100%; border-radius:10px; margin:10px 0;">` : ""}
            <p><strong>Autor:</strong> ${noticia.autor}</p>
            <small>Publicado el: ${noticia.fecha}</small>
            <p>${noticia.contenido}</p>
            ${videoId ? `<iframe width="100%" height="350" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allowfullscreen></iframe>` : ""}
            ${subtitulosHtml}
          `;
        })
        .catch(err => {
          console.error("Error al cargar la noticia:", err);
          document.getElementById("noticia").innerHTML = "<p>⚠ Error al cargar la noticia.</p>";
        });
    }
  </script>
</body>
</html>
