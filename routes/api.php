<?php

use Controllers\AuthController;

function routeRequest(string $uri, string $method)
{
    // Normalizamos la URI sin query params
    $path = explode('?', $uri)[0];

    if ($path === '/api/login' && $method === 'POST') {
        require_once __DIR__ . '/../controllers/AuthController.php';
        (new AuthController())->login();
        return;
    } elseif ($path === '/api/status' && $method === 'GET') {
        require_once __DIR__ . '/../controllers/StatusController.php';
        (new Controllers\StatusController())->getStatus();
        return;
    } elseif ($path === '/api/status/db' && $method === 'GET') {
        require_once __DIR__ . '/../controllers/StatusController.php';
        (new Controllers\StatusController())->getDbStatus();
        return;
    }

    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
