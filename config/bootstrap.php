<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuraciones globales
$appEnv = $_ENV['APP_ENV'] ?? 'production';
$viteHost = $_ENV['VITE_HOST'] ?? 'http://localhost:5173';
