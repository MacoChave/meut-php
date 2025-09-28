<?php

namespace Controllers;

use Helpers\Response;
use Services\PermissionService;

class PermissionController
{
    private PermissionService $permissionService;

    public function __construct()
    {
        $this->permissionService = new PermissionService();
    }

    public function getAll()
    {
        $permissions = $this->permissionService->getAllPermissions();
        Response::jsonResponse($permissions->status, $permissions->data, $permissions->error);
    }

    /**
     * Guardar los permisos por rol
     * @param int $idPagina ID de la página enviado por params
     * @param int $idRol ID del rol enviado por params
     * @param string $permissions Permisos enviados por el body
     */
    public function savePermissionsByRole(array $params)
    {
        $idPagina = isset($params['idPagina']) ? (int)$params['idPagina'] : 0;
        $idRol = isset($params['idRol']) ? (int)$params['idRol'] : 0;
        $body = json_decode(file_get_contents('php://input'), true);
        $permissions = isset($body['permissions']) ? $body['permissions'] : '';

        $result = $this->permissionService->savePermissionsByRole($idPagina, $idRol, $permissions);
        Response::jsonResponse($result->status, $result->data, $result->error);
    }

    /**
     * Guardar los permisos por usuario
     * @param int $idPagina ID de la página enviado por params
     * @param int $idUsuario ID del usuario enviado por params
     * @param string $permissions Permisos enviados por el body
     */
    public function savePermissionsByUser(array $params)
    {
        $idPagina = isset($params['idPagina']) ? (int)$params['idPagina'] : 0;
        $idUsuario = isset($params['idUsuario']) ? (int)$params['idUsuario'] : 0;
        $body = json_decode(file_get_contents('php://input'), true);
        $permissions = isset($body['permissions']) ? $body['permissions'] : '';

        $result = $this->permissionService->savePermissionsByUser($idPagina, $idUsuario, $permissions);
        Response::jsonResponse($result->status, $result->data, $result->error);
    }
}
