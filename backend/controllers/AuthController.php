<?php

namespace Controllers;

use DTO\LoginDTO;
use DTO\LogupDTO;
use DTO\ResponseDTO;
use DTO\UserDTO;
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

        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(new ResponseDTO(400, null, 'Correo electrónico y contraseña son obligatorios'));
            return;
        }

        $dto = new LoginDTO(
            trim($data['email'] ?? ''),
            trim($data['password'] ?? '')
        );

        $loginResponse = $this->authService->login($dto);

        header('Content-Type: application/json');
        http_response_code($loginResponse->userId ? 200 : 401);
        echo json_encode(new ResponseDTO(
            $loginResponse->userId ? 200 : 401,
            $loginResponse->userId ? ['userId' => $loginResponse->userId, 'token' => $loginResponse->token] : null,
            $loginResponse->userId ? null : 'Correo electrónico o contraseña incorrectos'
        ));
    }

    public function logup(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];

        $dto = new UserDTO(
            trim($data['firstName'] ?? ''),
            trim($data['lastName'] ?? ''),
            trim($data['gender'] ?? ''),
            trim($data['userRegister'] ?? ''),
            trim($data['userIdentification'] ?? ''),
            trim($data['userAddress'] ?? ''),
            trim($data['bornDate'] ?? ''),
            trim($data['phoneNumber'] ?? ''),
            trim($data['email'] ?? ''),
            trim($data['password'] ?? '')
        );

        $response = $this->authService->logup($dto);

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
