<?php
$dsn = "mysql:host=localhost;dbname=mi_base;charset=utf8mb4";
$username = "root";
$password = "";

try {
    return new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}
