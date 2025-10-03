// Datos de transmisión (puedes actualizar estos datos dinámicamente)
const transmissions = [
    {
        title: "Noticias en Vivo",
        description: "Últimas noticias de Puno y la región.",
        videoSrc: "video_noticias.mp4" // reemplaza con tu fuente vMix/NDI
    },
    {
        title: "Programa Cultural",
        description: "Conciertos y eventos culturales locales.",
        videoSrc: "video_cultural.mp4"
    },
    {
        title: "Deportes Regionales",
        description: "Resultados y entrevistas de deportes locales.",
        videoSrc: "video_deportes.mp4"
    }
];

let current = 0;

function updateTransmission() {
    const titleEl = document.getElementById('live-title');
    const descEl = document.getElementById('live-description');
    const videoEl = document.getElementById('live-video');

    titleEl.textContent = transmissions[current].title;
    descEl.textContent = transmissions[current].description;
    videoEl.src = transmissions[current].videoSrc;

    current = (current + 1) % transmissions.length;
}

// Cambiar transmisión cada 15 segundos
setInterval(updateTransmission, 15000);
