<?php

namespace Controllers;

use Helpers\Response;

class Rol
{
    // private PaginaService $paginaService;

    public function __construct()
    {
        // $this->paginaService = new PaginaService();
    }

    public function getAll()
    {
        Response::jsonResponse(200, null, 'Method not implemented');
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
