<?php

namespace Controllers;

use DTO\LoginRequestDTO;
use DTO\ResponseDTO;
use Services\AuthService;

class AuthController
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];

        $dto = new LoginRequestDTO(
            $data['email'] ?? '',
            $data['password'] ?? ''
        );

        $loginResponse = $this->authService->login($dto);

        header('Content-Type: application/json');
        http_response_code($loginResponse->userId ? 200 : 401);
        echo json_encode(new ResponseDTO(
            $loginResponse->userId ? 200 : 401,
            $loginResponse->userId ? ['userId' => $loginResponse->userId, 'token' => $loginResponse->token] : null,
            $loginResponse->userId ? null : 'Invalid email or password'
        ));
    }
}
