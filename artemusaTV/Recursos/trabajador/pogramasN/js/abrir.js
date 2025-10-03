// Función para abrir el modal
function openModal(imgSrc, title, desc) {
    document.getElementById("newsModal").style.display = "block";
    document.getElementById("modal-img").src = imgSrc;
    document.getElementById("modal-title").innerText = title;
    document.getElementById("modal-desc").innerText = desc;
}

// Función para cerrar el modal
function closeModal() {
    document.getElementById("newsModal").style.display = "none";
}

// Cierra el modal al hacer click fuera de la imagen
window.onclick = function(event) {
    const modal = document.getElementById("newsModal");
    if (event.target === modal) {
        closeModal();
    }
}