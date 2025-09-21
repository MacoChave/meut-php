<?php

namespace Controllers;

use Helpers\Log;
use Helpers\Response;
use Services\PageService;

class PageController
{
    private PageService $pageService;

    public function __construct()
    {
        $this->pageService = new PageService();
    }

    public function getAllChilds(array $params)
    {
        $idParent = $params['idPage'] ?? null;

        $pages = $this->pageService->getPagesByParent($idParent ? (int)$idParent : null);

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }

    public function getPagesWithPermissions()
    {
        $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

        if (!$authHeader) {
            Response::jsonResponse(401, null, 'No se envió el token');
            return;
        }

        if (!preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            Response::jsonResponse(401, null, 'Formato de token inválido');
            return;
        }

        $token = $matches[1];
        $payload = explode('.', $token)[1] ?? '';
        $decodedPayload = json_decode(base64_decode($payload), true);
        $userId = $decodedPayload['userId'] ?? null;

        $pages = $this->pageService->getPagesWithPermissions($userId);

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }

    public function getPermissionsByUsers()
    {
        $username = $_GET['username'] ?? null;
        $email = $_GET['email'] ?? null;
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $pages = $this->pageService->getPermissionsByUsers($username, $email);

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }

    public function getPermissionsByRole()
    {
        $rol = $_GET['rol'] ?? null;
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $pages = $this->pageService->getPermissionsByRoles($rol);

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }
}
