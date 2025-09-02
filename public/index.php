<?php
// require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../backend/config/bootstrap.php';

use Core\Router;

$router = new Router();

require_once __DIR__ . '/../backend/routes/api.php';

// Obtener ruta solicitada
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

// Si la ruta empieza con /api -> procesamos backend
if (strpos($uri, '/api') === 0) {
    $router->dispatch($uri, $method);
    exit;
}

// FRONTEND
if ($appEnv === 'development') {
    // En desarrollo, redirigimos al servidor de Vite
    $viteUrl = $viteHost . $uri;
    header("Location: $viteUrl");
    exit;
} else {
    // En producción, servimos los archivos estáticos desde 'public/dist/index.html'
    $distDir = __DIR__ . '/dist';
    $requestedFile = realpath($distDir . $uri);

    // Si el archivo existe (ej: /assets/main.js), lo servimos directamente
    if ($requestedFile && strpos($requestedFile, realpath($distDir)) === 0 && is_file($requestedFile)) {
        return readfile($requestedFile);
    }

    // Si no existe, devolvemos index.html (SPA fallback)
    $indexFile = $distDir . '/index.html';
    if (file_exists($indexFile)) {
        header('Content-Type: text/html; charset=utf-8');
        readfile($indexFile);
        exit;
    }

    http_response_code(404);
    echo "Archivo no encontrado.";
}
