// Selecciona el toggle y el menú
const toggle = document.querySelector(".menu-toggle");
const menu = document.querySelector("nav ul");

// Evento click para mostrar/ocultar el menú
toggle.addEventListener("click", () => {
    menu.classList.toggle("active");
});
