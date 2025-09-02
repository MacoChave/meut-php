<?php

namespace Core;

class Router
{
    private array $routes = [];

    public function add(string $method, string $pattern, callable|array $handler, array $middlewares = []): void
    {
        // Convertimos {param} en regex
        $regex = preg_replace('#\{([\w]+)\}#', '(?P<$1>[^/]+)', $pattern);
        $regex = "#^" . $regex . "$#";

        $this->routes[$method][] = [
            'pattern' => $regex,
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    public function dispatch(string $uri, string $method): void
    {
        $path = explode('?', $uri)[0];
        $method = strtoupper($method);

        if (!isset($this->routes[$method])) {
            $this->notFound();
            return;
        }

        foreach ($this->routes[$method] as $route) {
            if (preg_match($route['pattern'], $path, $matches)) {
                // Ejecutar middlewares
                foreach ($route['middlewares'] as $middleware) {
                    $middlewareResult = (new $middleware())->handle();
                    if ($middlewareResult === false) {
                        http_response_code(403);
                        echo json_encode(['error' => 'Forbidden']);
                        return;
                    }
                }

                // Ejecutar controlador
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $handler = $route['handler'];

                if (is_array($handler)) {
                    [$controllerClass, $action] = $handler;

                    // Autocargar controlador
                    $controllerFile = __DIR__ . '/../controllers/' . basename(str_replace('\\', '/', $controllerClass)) . '.php';
                    if (!class_exists($controllerClass) && file_exists($controllerFile)) {
                        require_once $controllerFile;
                    }

                    $controller = new $controllerClass();
                    $controller->$action($params);
                } else {
                    call_user_func($handler, $params);
                }

                return;
            }
        }

        $this->notFound();
    }

    private function notFound(): void
    {
        http_response_code(404);
        echo json_encode(['error' => 'Ruta no encontrada']);
    }
}
