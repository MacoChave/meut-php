<?php

require_once __DIR__ . '/../core/Router.php';

function routeRequest(string $uri, string $method)
{
    // Normalizamos la URI sin query params
    $path = explode('?', $uri)[0];

    $routes = [
        'POST' => [
            '/api/login' => [Controllers\AuthController::class, 'login'],
        ],
        'GET' => [
            '/api/status' => [Controllers\StatusController::class, 'getStatus'],
            '/api/status/db' => [Controllers\StatusController::class, 'getDbStatus'],
        ],
    ];

    // Verificamos si la ruta y método existen
    if (isset($routes[$method][$path])) {
        [$controllerClass, $methodName] = $routes[$method][$path];

        // Cargar el archivo del controlador solo si no está definido
        $controllerFile = __DIR__ . '/../controllers/' . basename(str_replace('\\', '/', $controllerClass)) . '.php';
        if (!class_exists($controllerClass) && file_exists($controllerFile)) {
            require_once $controllerFile;
        }

        // Ejecutar acción
        $controller = new $controllerClass();
        $controller->$methodName();
        return;
    }

    // Si no existe
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
