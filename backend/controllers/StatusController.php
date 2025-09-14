<?php

namespace Controllers;

use Services\StatusService;

class StatusController
{

    public function getStatus(): void
    {
        $statusService = new StatusService();
        $status = $statusService->getStatus();

        header('Content-Type: application/json');
        echo json_encode($status);
    }

    public function getDbStatus(): void
    {
        $statusService = new StatusService();
        $dbStatus = $statusService->getDbStatus();

        header('Content-Type: application/json');
        echo json_encode($dbStatus);
    }
}
