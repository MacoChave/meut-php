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
}
