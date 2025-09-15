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

    public function getAll()
    {
        $pages = $this->pageService->getPages();

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }

    public function getOne()
    {
        Response::jsonResponse(200, null, 'Method not implemented');
    }

    public function create()
    {
        Response::jsonResponse(200, null, 'Method not implemented');
    }

    public function edit()
    {
        Response::jsonResponse(200, null, 'Method not implemented');
    }

    public function delete()
    {
        Response::jsonResponse(200, null, 'Method not implemented');
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
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $pages = $this->pageService->getPermissionsByUsers($data['username'], $data['email']);

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }

    public function getPermissionsByRole()
    {
        $body = file_get_contents('php://input');
        $data = json_decode($body, true);
        $pages = $this->pageService->getPermissionsByRoles($data['rol']);

        Response::jsonResponse($pages->status, $pages->data, $pages->error);
    }
}
