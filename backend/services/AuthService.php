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
    public function login(LoginDTO $login): LoginResponseDTO
    {
        $user = UserRepository::findByEmail($login->email);

        if (!$user) {
            http_response_code(401);
            return new LoginResponseDTO(0, '');
        }

        if (!password_verify($login->password, $user['password'])) {
            http_response_code(401);
            return new LoginResponseDTO(0, '');
        }

        $payload = [
            'userId' => $user['id'],
            'email' => $user['email'],
            'iat' => time(),
            'exp' => time() + getenv('JWT_EXPIRATION', 60 * 60) // Token válido por 1 hora
        ];
        $token = JWT::encode($payload, getenv('JWT_SECRET', 'secret'), 'HS256');

        return new LoginResponseDTO($user['id'], $token);
    }

    public function logup(UserDTO $user): ResponseDTO
    {
        // Hash the password before storing it
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);

        $newUser = UserRepository::insertUser($user);

        return new ResponseDTO(
            $newUser ? 201 : 500,
            null,
            'Usuario creado exitosamente'
        );
    }
}
