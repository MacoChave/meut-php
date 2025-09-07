<?php

namespace Controllers;

use DTO\LoginDTO;
use DTO\ResponseDTO;
use DTO\UserDTO;
use Helpers\Log;
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

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            echo json_encode(new ResponseDTO(400, null, 'JSON inválido'));
            return;
        }

        if (!isset($data['email']) || !isset($data['password']) || empty(trim($data['email'])) || empty(trim($data['password']))) {
            http_response_code(400);
            echo json_encode(new ResponseDTO(400, null, 'Correo electrónico y contraseña son obligatorios'));
            return;
        }

        $dto = new LoginDTO(
            trim($data['email'] ?? ''),
            trim($data['password'] ?? '')
        );

        $loginResponse = $this->authService->login($dto);

        $this->sendResponse($loginResponse->status, $loginResponse->data, $loginResponse->error);
    }

    public function logup(): void
    {
        $data = json_decode(file_get_contents('php://input'), true) ?? [];

        Log::info(json_encode($data));

        $dto = new UserDTO(
            trim($data['firstName'] ?? ''),
            trim($data['lastName'] ?? ''),
            trim($data['gender'] ?? ''),
            trim($data['userRegister'] ?? ''),
            trim($data['userIdentification'] ?? ''),
            trim($data['userAddress'] ?? ''),
            trim($data['bornDate'] ?? ''),
            trim($data['phone'] ?? ''),
            trim($data['email'] ?? ''),
            trim($data['password'] ?? ''),
            trim($data['municipality_id'] ?? 0)
        );

        $response = $this->authService->logup($dto, $data['rol'] ?? 6);

        Log::info(json_encode($response));

        $this->sendResponse($response->status, $response->data, $response->error);
    }

    private function sendResponse(int $status, $data = null, ?string $error = null): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode(new ResponseDTO($status, $data, $error));
    }
}
