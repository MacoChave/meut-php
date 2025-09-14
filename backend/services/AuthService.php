<?php

namespace Services;

use DTO\LoginDTO;
use DTO\ResponseDTO;
use DTO\UserDTO;
use Firebase\JWT\JWT;
use Helpers\Log;
use Repositories\UserRepository;

class AuthService
{
    public function login(LoginDTO $login): ResponseDTO
    {
        $resultUser = UserRepository::findByEmail($login->email);

        if ($resultUser->status !== 200) {
            http_response_code($resultUser->status);
            return new ResponseDTO($resultUser->status, $resultUser->data, $resultUser->error);
        }

        if ($resultUser->data === null) {
            http_response_code(404);
            return new ResponseDTO(404, null, 'Usuario no encontrado');
        }

        $userData = $resultUser->data;

        if (!isset($userData['pass']) || !password_verify($login->password, $userData['pass'])) {
            http_response_code(401);
            return new ResponseDTO(401, null, 'Credenciales inválidas');
        }

        $payload = [
            'userId' => $userData['id_usuario'],
            'email' => $userData['correo'] ?? '',
            'iat' => time(),
            'exp' => time() + $_ENV['JWT_EXPIRATION'] ?? 60 * 60 // Token válido por 1 hora
        ];

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

        $pageServce = new PageService();

        $permissions = $pageServce->getPagesWithPermissions((int)$userData['id_usuario'])->data;

        return new ResponseDTO(200, ['email' => $userData['correo'], 'token' => $token, 'permissions' => $permissions], null);
    }

    public function logup(UserDTO $user, string $id_rol): ResponseDTO
    {
        $result = UserRepository::insertUser($user, $id_rol);

        return $result;
    }
}
