<?php

namespace Services;

use Repositories\StatusRepository;

class StatusService
{
    public function getStatus(): array
    {
        return ['status' => 'ok', 'timestamp' => time()];
    }

    public function getDbStatus(): array
    {
        try {
            $statusRepository = new StatusRepository();
            return $statusRepository->getDbStatus();
        } catch (\Throwable $th) {
            return ['repository' => 'down', 'error' => $th->getMessage()];
        }
    }
}
