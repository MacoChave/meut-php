<?php

namespace Controllers;

class UserController
{
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
}
