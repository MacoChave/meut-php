<?php

namespace Services;

use DTO\LoginDTO;
use DTO\LoginResponseDTO;
use DTO\ResponseDTO;
use DTO\UserDTO;
use Firebase\JWT\JWT;
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
            'email' => $userData['email'],
            'iat' => time(),
            'exp' => time() + getenv('JWT_EXPIRATION', 60 * 60) // Token válido por 1 hora
        ];
        $token = JWT::encode($payload, getenv('JWT_SECRET', 'secret'), 'HS256');

        return new ResponseDTO(200, ['userId' => $userData['id_usuario'], 'email' => $userData['correo'], 'token' => $token], null);
    }

    public function logup(UserDTO $user): ResponseDTO
    {
        $result = UserRepository::insertUser($user);

        return $result;
    }
}
