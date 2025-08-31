<?php

namespace Services;

use DTO\LoginRequestDTO;
use DTO\LoginResponseDTO;
use DTO\ResponseDTO;
use Firebase\JWT\JWT;
use Models\UserModels;

class AuthService
{
    public function login(LoginRequestDTO $login): LoginResponseDTO
    {
        $user = UserModels::findByEmail($login->email);

        if (!$user || !password_verify($login->password, $user['password'])) {
            return new LoginResponseDTO(0, "");
        }

        $payload = [
            'userId' => $user['id'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + (60 * 60) // Token válido por 1 hora
        ];
        $jwtToken = require __DIR__ . '/../config/jwt.php';
        $token = JWT::encode($payload, $jwtToken, 'HS256');

        return new LoginResponseDTO($user['id'], $token);
    }
}
