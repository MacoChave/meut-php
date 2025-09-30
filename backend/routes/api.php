<?php

use Controllers\AuthController;
use Controllers\ConstantController;
use Controllers\LocationController;
use Controllers\PageController;
use Controllers\PermissionController;
use Controllers\RolController;
use Controllers\StatusController;
use Controllers\UserController;
use Core\Router;

header('Access-Control-Allow-Origin: http://localhost:5173');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$router->add('GET', '/api/status', [StatusController::class, 'getStatus']);
$router->add('GET', '/api/status/db', [StatusController::class, 'getDbStatus']);

$router->add('POST', '/api/login', [AuthController::class, 'login']);
$router->add('POST', '/api/logup', [AuthController::class, 'logup']);

$router->add('GET', '/api/location/departments', [LocationController::class, 'getDepartments']);
$router->add('GET', '/api/location/departments/{id_department}/municipality', [LocationController::class, 'getMunicipalities']);

$router->add('GET', '/api/rol', [RolController::class, 'getAll']);

$router->add('GET', '/api/permission', [PermissionController::class, 'getAll']);
$router->add('GET', '/api/permission/users', [PageController::class, 'getPermissionsByUsers']);
$router->add('GET', '/api/permission/role', [PageController::class, 'getPermissionsByRole']);
$router->add('POST', '/api/permission/{idPagina}/role/{idRol}', [PermissionController::class, 'savePermissionsByRole']);

$router->add('GET', '/api/page/{idPage}', [PageController::class, 'getAllChilds']);

$router->add('GET', '/api/users/{id}', [UserController::class, 'getUserById']);
$router->add('GET', '/api/user/template', [UserController::class, 'getUserTemplate']);

$router->add('GET', '/api/constant/{id}', [ConstantController::class, 'getConstants']);
