<?php

namespace Repositories;

use DTO\ResponseDTO;
use DTO\UserDTO;
use PDO;
use PDOException;

class UserRepository
{
    public static function findByEmail(string $email): ResponseDTO
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT * FROM usuario WHERE correo = :email");
            $stmt->execute([":email" => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                return new ResponseDTO(404, null, 'Usuario no encontrado');
            }

            return new ResponseDTO(200, $user, null);
        } catch (PDOException $ex) {
            return new ResponseDTO(500, null, 'Error al obtener el usuario: ' . $ex->getMessage());
        }
    }

    public static function findById(int $id): ResponseDTO
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT id, nombre, apellido, genero, usuario_registro, identificacion, direccion, fecha_nacimiento, telefono, correo FROM usuario WHERE id = :id");
            $stmt->execute([":id" => $id]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return new ResponseDTO(200, $user, null);
            } else {
                return new ResponseDTO(404, null, 'Usuario no encontrado');
            }
        } catch (PDOException $ex) {
            return new ResponseDTO(500, null, 'Error al obtener el usuario: ' . $ex->getMessage());
        }
    }

    public static function insertUser(UserDTO $user): ResponseDTO
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            // EXEC PROCEDURE ut_sp_crear_usuario
            $stmt = $pdo->prepare("CALL ut_sp_crear_usuario(:nombre, :apellido, :genero, :usuario_registro, :identificacion, :direccion, :fecha_nacimiento, 1, 3, :telefono, :correo, :contrasena)");

            $stmt->execute([
                ":nombre" => $user->first_name,
                ":apellido" => $user->last_name,
                ":genero" => $user->genre,
                ":usuario_registro" => $user->register_id,
                ":identificacion" => $user->uid,
                ":direccion" => $user->address,
                ":fecha_nacimiento" => $user->birth_date,
                ":telefono" => $user->phone ?? 0,
                ":correo" => $user->email,
                ":contrasena" => password_hash($user->password, PASSWORD_BCRYPT),
            ]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return new ResponseDTO(200, $result, null);
        } catch (PDOException $ex) {
            return new ResponseDTO(500, null, 'Error al crear el usuario: ' . $ex->getMessage());
        }
    }
}
