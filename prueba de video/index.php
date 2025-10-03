<?php
$m3uUrl = "http://64.76.204.10:25461/get.php?username=puno&password=puno&type=m3u&output=hls";
$m3uContent = @file_get_contents($m3uUrl);

$canalBuscado = "ARTEMUSA TV HD";
$canalUrl = "";

if ($m3uContent !== false) {
    $lineas = explode("\n", $m3uContent);
    $nombre = "";
    foreach ($lineas as $linea) {
        $linea = trim($linea);
        if (strpos($linea, "#EXTINF:") === 0) {
            $partes = explode(",", $linea, 2);
            $nombre = $partes[1] ?? "";
        } elseif ($linea !== "" && !str_starts_with($linea, "#")) {
            if (stripos($nombre, $canalBuscado) !== false) {
                $canalUrl = $linea;
                break;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $canalBuscado; ?></title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background: #000;
        }
        video {
            width: 100%;
            height: 100%;
            background: #000;
        }
    </style>
</head>
<body>

<?php if ($canalUrl): ?>
    <video id="video" controls autoplay></video>

    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
    <script>
        var video = document.getElementById('video');
        var videoSrc = "<?php echo $canalUrl; ?>";
        var hls;

        if (Hls.isSupported()) {
            hls = new Hls();
            hls.loadSource(videoSrc);
            hls.attachMedia(video);
            hls.on(Hls.Events.MANIFEST_PARSED, function () {
                video.play();
            });
        } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
            video.src = videoSrc;
            video.play();
        } else {
            alert("Tu navegador no soporta HLS.");
        }
    </script>
<?php else: ?>
    <p style="color:white; text-align:center; margin-top:20%;">No se encontró el canal "<?php echo $canalBuscado; ?>"</p>
<?php endif; ?>

</body>
</html>
