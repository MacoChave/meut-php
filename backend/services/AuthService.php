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

        Log::info('user : ' . json_encode($resultUser));

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
        Log::info('Payload : ' . json_encode($payload));
        Log::info('JWT_EXP : ' . $_ENV['JWT_EXPIRATION'] ?? 60 * 60);
        Log::info('JWT_SECRET : ' . $_ENV['JWT_SECRET'] ?? 'jwt-secret');

        $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');

        return new ResponseDTO(200, ['userId' => $userData['id_usuario'], 'email' => $userData['correo'], 'token' => $token], null);
    }

    public function logup(UserDTO $user, string $id_rol): ResponseDTO
    {
        $result = UserRepository::insertUser($user, $id_rol);

        return $result;
    }
}
