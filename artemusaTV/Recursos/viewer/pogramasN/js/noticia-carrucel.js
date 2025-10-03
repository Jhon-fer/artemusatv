const carousel = document.getElementById('news-carousel');
const maxNews = 5; // Máximo número de noticias visibles
const intervalTime = 3000; // 3 segundos por movimiento

// Función para mover el primer elemento al final
function rotateNews() {
    if (carousel.children.length > 1) {
        // Animación hacia arriba
        const first = carousel.children[0];
        first.style.marginTop = '-100%';
        first.style.transition = 'margin-top 0.5s';

        setTimeout(() => {
            first.style.transition = '';
            first.style.marginTop = '';
            carousel.appendChild(first); // Mueve el primer elemento al final

            // Limitar la cantidad de noticias
            while (carousel.children.length > maxNews) {
                carousel.removeChild(carousel.children[0]);
            }
        }, 500);
    }
}

// Iniciar rotación automática
setInterval(rotateNews, intervalTime);
