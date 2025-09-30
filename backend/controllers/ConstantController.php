<?php

namespace Controllers;

use Helpers\Response;
use Services\ConstantService;

class ConstantController
{
    private ConstantService $constant_service;

    public function __construct()
    {
        $this->constant_service = new ConstantService();
    }

    public function getConstants(array $params): void
    {
        $id = $params['id'] ?? null;

        $constant = $this->constant_service->getConstants($id);

        Response::jsonResponse($constant->status, $constant->data, $constant->error);
    }

    public function updateConstant(array $params): void
    {
        $id = $params['id'] ?? null;
        $body = json_decode(file_get_contents('php://input'), true);
        $name = $body['name'] ?? null;
        $value = $body['value'] ?? null;

        if (!$id || !$name || !$value) {
            Response::jsonResponse(400, null, "Faltan parámetros obligatorios");
            return;
        }

        $constant = $this->constant_service->updateConstant($id, $name, $value);

        Response::jsonResponse($constant->status, $constant->data, $constant->error);
    }
}
