<?php

namespace Controllers;

use Helpers\Response;
use Services\RolService;

class RolController
{
    private RolService $paginaService;

    public function __construct()
    {
        $this->paginaService = new RolService();
    }

    public function getAll()
    {
        $roles = $this->paginaService->getAllRoles();
        Response::jsonResponse($roles->status, $roles->data, $roles->error);
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
}
