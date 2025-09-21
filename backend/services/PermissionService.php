<?php

namespace Services;

use DTO\ResponseDTO;
use Exception;
use Helpers\Log;
use Repositories\PermissionRepository;

class PermissionService
{
    public function getAllPermissions()
    {
        try {
            $result = PermissionRepository::getAllPermissions();

            if (!$result) return new ResponseDTO(404, null, 'No se encontraron permisos');
            return new ResponseDTO(200, $result, null);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['class' => 'PermissionService', 'method' => 'getAllPermissions']);
            return new ResponseDTO(500, null, 'Hubo un error al procesar la solicitud');
        }
    }
}
