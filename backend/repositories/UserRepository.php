<?php

namespace Repositories;

use DTO\UserDTO;
use PDO;

class UserRepository
{
    public static function findByEmail(string $email): ?array
    {
        $pdo = require __DIR__ . "/../config/database.php";

        $stmt = $pdo->prepare("SELECT * FROM usuario WHERE correo = :email");
        $stmt->execute([":email" => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function findById(int $id): ?array
    {
        $pdo = require __DIR__ . "/../config/database.php";

        $stmt = $pdo->prepare("SELECT id, nombre, apellido, genero, usuario_registro, identificacion, direccion, fecha_nacimiento, telefono, correo FROM usuario WHERE id = :id");
        $stmt->execute([":id" => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function insertUser(UserDTO $user): int
    {
        $pdo = require __DIR__ . "/../config/database.php";
        $stmt = $pdo->prepare("INSERT INTO usuario (nombre, apellidos, genero, carnet, cui, direccion, fecha_nac, telefono, correo, pass, created_at) VALUES (:first_name, :last_name, :genre, :register_id, :uid, :address, :birth_date, :phone, :email, :password, 'active', NOW())");

        $stmt->bindParam(':first_name', $user->first_name);
        $stmt->bindParam(':last_name', $user->last_name);
        $stmt->bindParam(':genre', $user->genre);
        $stmt->bindParam(':register_id', $user->register_id);
        $stmt->bindParam(':uid', $user->uid);
        $stmt->bindParam(':address', $user->address);
        $stmt->bindParam(':birth_date', $user->birth_date);
        $stmt->bindParam(':phone', $user->phone);
        $stmt->bindParam(':email', $user->email);
        $stmt->bindParam(':password', $user->password);
        $stmt->execute();
        return $pdo->lastInsertId();
    }
}
