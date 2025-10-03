// ✅ Cargar noticias al iniciar
document.addEventListener("DOMContentLoaded", cargarNoticias);

// ✅ Evento para guardar nueva noticia
document.getElementById("form-noticia").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = document.getElementById("form-noticia");
  const formData = new FormData(form); // Captura todos los inputs, incluyendo la imagen

  fetch("agregar.php", {
    method: "POST",
    body: formData
  })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      cargarNoticias(); // Recarga la lista
      form.reset(); // Limpia el formulario
    })
    .catch(err => console.error("Error:", err));
});

// ✅ Función para mostrar noticias (título + imagen + resumen)
function cargarNoticias() {
  fetch("data/noticias.json?nocache=" + new Date().getTime())
    .then(res => res.json())
    .then(noticias => {
      const contenedor = document.getElementById("contenedor-noticias");
      contenedor.innerHTML = "";

      if (!noticias || noticias.length === 0) {
        contenedor.innerHTML = "<p>No hay noticias todavía.</p>";
        return;
      }

      // Mostrar en orden más reciente primero
      noticias.slice().reverse().forEach(n => {
        console.log("Noticia cargada:", n); // 👈 prueba en consola

        // 🔹 Generar resumen (máx. 120 caracteres)
        let resumen = n.contenido ? n.contenido : "";
        if (resumen.length > 120) {
          resumen = resumen.substring(0, 120) + "...";
        }

        const card = document.createElement("div");
        card.classList.add("noticia");

        card.innerHTML = `
          <h3>${n.titulo}</h3>
          ${n.imagen ? `<img src="${n.imagen}" alt="Imagen de noticia" style="max-width:100%; border-radius:10px; margin-bottom:8px;">` : ""}
          <p class="resumen">${resumen}</p>
          <a href="noticias.html?id=${n.id}">Leer más ➡</a>
        `;

        contenedor.appendChild(card);
      });
    })
    .catch(err => console.error("Error al cargar noticias:", err));
}

// Previsualizar imagen principal
document.getElementById('imagen-principal-file').addEventListener('change', function(e){
    const file = e.target.files[0];
    if(file){
        const reader = new FileReader();
        reader.onload = function(event){
            document.getElementById('imagen-principal-preview').src = event.target.result;
        }
        reader.readAsDataURL(file);
    }
});

// Previsualizar imágenes laterales
document.getElementById('imagenes-laterales-file').addEventListener('change', function(e){
    const files = e.target.files;
    const previewDiv = document.getElementById('preview-laterales');
    previewDiv.innerHTML = '';
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(event){
            const img = document.createElement('img');
            img.src = event.target.result;
            img.style.width = '100px';
            img.style.borderRadius = '5px';
            previewDiv.appendChild(img);
        }
        reader.readAsDataURL(file);
    });
});

// Enviar formulario (guardar noticia en PHP)
document.getElementById('form-noticia').addEventListener('submit', function(e){
    e.preventDefault();

    const form = e.target;

    // Validación de campos obligatorios
    if(!form.checkValidity()){
        form.reportValidity();
        return;
    }

    const id = document.getElementById('noticia-id') ? document.getElementById('noticia-id').value : null;
    const titulo = document.getElementById('titulo').value;
    const autor = document.getElementById('autor').value;
    const contenido = document.getElementById('contenido').value;
    const video = document.getElementById('video').value;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('titulo', titulo);
    formData.append('autor', autor);
    formData.append('contenido', contenido);
    formData.append('video', video);

    const imgPrincipal = document.getElementById('imagen').files[0];
    if(imgPrincipal) formData.append('imagen_principal', imgPrincipal);

    // Si agregas imágenes laterales, también puedes añadir aquí
    // const imgsLaterales = document.getElementById('imagenes-laterales-file').files;
    // Array.from(imgsLaterales).forEach(file => formData.append('imagenes_laterales[]', file));

    fetch('guardar_noticia.php', { method: 'POST', body: formData })
      .then(res => res.json())
      .then(data => {
          alert(data.mensaje);
          form.reset();
          cargarNoticias(); // recarga la lista de noticias
      })
      .catch(err => console.error(err));
});
