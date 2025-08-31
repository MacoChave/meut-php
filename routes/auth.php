<?php

use Controllers\AuthController;

$path = $_SERVER["REQUEST_URI"];
$method = $_SERVER["REQUEST_METHOD"];

if ($path === "/api/login" && $method === "POST") {
    // Log en consola para indicar que entró a la ruta
    error_log("Entrando a la ruta /api/login");
    $controller = new AuthController();
    $controller->login();
    exit;
}
