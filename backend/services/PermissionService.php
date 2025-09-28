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

    public function savePermissionsByRole($idPagina, $idRol, $permissions)
    {
        try {
            $result = PermissionRepository::savePermissionsByRole($idPagina, $idRol, $permissions);

            Log::info('Permissions result', ['class' => 'PermissionService', 'method' => 'savePermissionsByRole', 'result' => $result]);

            if (!$result) return new ResponseDTO(404, null, 'No se pudieron guardar los permisos');
            return new ResponseDTO(200, $result, null);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['class' => 'PermissionService', 'method' => 'savePermissionsByRole']);
            return new ResponseDTO(500, null, 'Hubo un error al procesar la solicitud');
        }
    }

    public function savePermissionsByUser($idPagina, $idUsuario, $permissions)
    {
        try {
            $result = PermissionRepository::savePermissionsByUser($idPagina, $idUsuario, $permissions);

            if (!$result) return new ResponseDTO(404, null, 'No se pudieron guardar los permisos');
            return new ResponseDTO(200, $result, null);
        } catch (Exception $ex) {
            Log::error($ex->getMessage(), ['class' => 'PermissionService', 'method' => 'savePermissionsByUser']);
            return new ResponseDTO(500, null, 'Hubo un error al procesar la solicitud');
        }
    }
}
