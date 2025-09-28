<?php

namespace Controllers;

use Services\UserService;

class UserController
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function getUserById(array $params): void
    {
        $userId = $params['id'] ?? null;

        if ($userId === null || !is_numeric($userId)) {
            http_response_code(400);
            echo json_encode(['error' => 'ID de usuario inválido']);
            return;
        }

        // Aquí iría la lógica para obtener el usuario desde la base de datos
        // Por simplicidad, devolvemos un usuario simulado
        $user = [
            'id' => (int)$userId,
            'name' => 'Usuario ' . $userId,
            'email' => 'user' . $userId . '@example.com'
        ];

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($user);
    }

    /**
     * Obtiene un archivo Excel con la plantilla de usuarios para una carga masiva.
     */
    public function getUserTemplate(): void
    {
        $filePath = $this->userService->getUserTemplatePath();

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo json_encode(['error' => 'Plantilla no encontrada']);
            return;
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="user_template.xlsx"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    }
}
