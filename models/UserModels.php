<?php

namespace Models;

use PDO;

class UserModels
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = require __DIR__ . "/../config/database.php";

        $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = :email");
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
