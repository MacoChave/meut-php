<?php

namespace Services;

use DTO\ResponseDTO;
use Exception;
use Helpers\Log;
use Repositories\RolRepository;

class RolService
{
    public function getAllRoles()
    {
        try {
            $result = RolRepository::getAllRoles();

            if (!$result) return new ResponseDTO(404, null, 'No se encontraron roles');
            return new ResponseDTO(200, $result, null);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['class' => 'RolService', 'method' => 'getAllRoles']);
            return new ResponseDTO(500, null, 'Hubo un error al procesar la solicitud');
        }
    }
}
