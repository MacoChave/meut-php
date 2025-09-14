<?php

namespace Controllers;

use Helpers\Log;
use Helpers\Response;
use Services\LocationService;

class LocationController
{
    private LocationService $location_service;

    public function __construct()
    {
        $this->location_service = new LocationService();
    }

    public function getDepartments(): void
    {
        $department = $this->location_service->getDepartments();

        Response::jsonResponse($department->status, $department->data, $department->error);
    }

    public function getMunicipalities(array $params): void
    {
        $idDepartment = $params['id_department'] ?? null;

        $department = $this->location_service->getMunicipalities($idDepartment);

        Response::jsonResponse($department->status, $department->data, $department->error);
    }
}
