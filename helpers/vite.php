<?php

function vite(string $entry): string
{
    $appEnv = $_ENV['APP_ENV'] ?? 'production';
    $viteHost = $_ENV['VITE_HOST'] ?? 'http://localhost:5173';

    if ($appEnv === 'development') {
        // DEV MODE -> Cargar desde servidor vite
        return <<<HTML
<script type="module" src="$viteHost/@vite/client"></script>
<script type="module" src="$viteHost/$entry"></script>
HTML;
    }

    // PROD MODE -> Leer manifest.json
    $manifestPath = __DIR__ . '/../public/dist/.vite/manifest.json';

    if (!file_exists($manifestPath)) {
        throw new RuntimeException("El archivo de manifiesto de Vite no se encontró en $manifestPath. ¿Has ejecutado la compilación de producción?");
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);
    if (!isset($manifest[$entry])) {
        throw new RuntimeException("La entrada '$entry' no se encontró en el manifiesto de Vite.");
    }

    $entryData = $manifest[$entry];

    $html = '';
    if (isset($entryData['css'])) {
        foreach ($entryData['css'] as $cssFile) {
            $html .= '<link rel="stylesheet" href="/dist/' . $cssFile . '">' . PHP_EOL;
        }
    }

    $html .= '<script type="module" src="/dist/' . $entryData['file'] . '"></script>' . PHP_EOL;
    return $html;
}
