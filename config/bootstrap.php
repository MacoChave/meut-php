<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configuraciones globales
$appName = $_ENV['APP_NAME'] ?? 'MyApp';
$appEnv = $_ENV['APP_ENV'] ?? 'production';
$appDebug = $_ENV['APP_DEBUG'] ?? 'false';

$viteHost = $_ENV['VITE_HOST'] ?? 'http://localhost:5173';
$jwtSecret = $_ENV['JWT_SECRET'];
$jwtExpiration = $_ENV['JWT_EXPIRATION'] ?? '3600'; // en segundos
$salt = $_ENV['SALT'] ?? 'default_salt';

$logChannel = $_ENV['LOG_CHANNEL'] ?? 'app.log';

$awsAccessKeyId = $_ENV['AWS_ACCESS_KEY_ID'] ?? '';
$awsSecretAccessKey = $_ENV['AWS_SECRET_ACCESS_KEY'] ?? '';
$awsRegion = $_ENV['AWS_REGION'] ?? 'us-east-1';
$awsBucket = $_ENV['AWS_BUCKET'] ?? '';
