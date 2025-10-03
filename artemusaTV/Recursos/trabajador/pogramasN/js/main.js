// ✅ Cargar noticias al iniciar
document.addEventListener("DOMContentLoaded", cargarNoticias);

// ✅ Función para mostrar noticias (título + imagen + resumen)
function cargarNoticias() {
  fetch("http://localhost/Practicas/artemusaTV/Recursos/trabajador/pogramasN/data/noticias.json?nocache=" + new Date().getTime())
    .then(res => {
      if (!res.ok) throw new Error("Error al leer noticias.json");
      return res.json();
    })
    .then(noticias => {
      const contenedor = document.getElementById("contenedor-noticias");
      contenedor.innerHTML = "";

      if (!noticias || noticias.length === 0) {
        contenedor.innerHTML = "<p>No hay noticias todavía.</p>";
        return;
      }

      // Mostrar en orden más reciente primero
      noticias.slice().reverse().forEach(n => {
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
          <button onclick="openModal('${n.imagen}', '${n.titulo}', '${n.contenido}')">Leer más ➡</button>
        `;

        contenedor.appendChild(card);
      });
    })
    .catch(err => {
      console.error("Error al cargar noticias:", err);
      document.getElementById("contenedor-noticias").innerHTML =
        `<p style="color:red">⚠ No se pudieron cargar las noticias</p>`;
    });
}

// ✅ Evento único para guardar nueva noticia
document.getElementById("form-noticia").addEventListener("submit", function (e) {
  e.preventDefault();

  const form = e.target;

  // Validación de campos obligatorios
  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  const formData = new FormData(form);

  fetch("guardar_noticia.php", { method: "POST", body: formData })
    .then(res => res.json())
    .then(data => {
      alert(data.mensaje);
      form.reset();
      cargarNoticias(); // recarga la lista de noticias
    })
    .catch(err => console.error("Error al guardar noticia:", err));
});

// ✅ Previsualizar imagen principal
document.getElementById('imagen').addEventListener('change', function (e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (event) {
      const preview = document.getElementById('imagen-principal-preview');
      if (preview) {
        preview.src = event.target.result;
        preview.style.display = "block";
      }
    };
    reader.readAsDataURL(file);
  }
});
