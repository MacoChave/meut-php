<?php

use Controllers\AuthController;
use Controllers\StatusController;
use Controllers\UserController;
use Core\Router;

$router->add('POST', '/api/login', [AuthController::class, 'login']);
$router->add('GET', '/api/status', [StatusController::class, 'getStatus']);
$router->add('GET', '/api/status/db', [StatusController::class, 'getDbStatus']);

$router->add('GET', '/api/users/{id}', [UserController::class, 'getUserById']);
