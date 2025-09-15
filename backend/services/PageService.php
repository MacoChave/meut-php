<?php

namespace Services;

use DTO\ResponseDTO;
use Helpers\Log;
use Repositories\PageRepository;

class PageService
{
    public function getPages(): ResponseDTO
    {
        try {
            $result = PageRepository::getAll();

            if (!$result) return new ResponseDTO(404, null, 'No se encontraron páginas');

            return new ResponseDTO(200, $result, null);
        } catch (\Exception $th) {
            return new ResponseDTO(500, null, 'Hubo un error al procesar la solicitud');
        }
    }

    public function getPagesWithPermissions(int $userId): ResponseDTO
    {
        try {
            $result = PageRepository::getPagesWithPermissions($userId);

            if (!$result) return new ResponseDTO(404, null, 'No se encontraron páginas');

            // Formar la estructura jerárquica de las páginas agrupando por id_padre
            $pages = [];
            foreach ($result as $page) {
                if ($pages[$page['nombre_padre']] === null) {
                    $pages[$page['nombre_padre']] = [
                        'id' => $page['id_padre'],
                        'nombre' => $page['nombre_padre'],
                        'ruta' => null,
                        'icono' => null,
                        'hijos' => []
                    ];
                }
                if ($page['id_padre'] === null) {
                    $pages[$page['id']] = [
                        'id' => $page['id'],
                        'nombre' => $page['nombre'],
                        'ruta' => $page['ruta'],
                        'icono' => $page['icono'],
                        'hijos' => []
                    ];
                } else {
                    if (isset($pages[$page['nombre_padre']])) {
                        $pages[$page['nombre_padre']]['hijos'][] = [
                            'id' => $page['id_hijo'],
                            'nombre' => $page['nombre_hijo'],
                            'ruta' => $page['ruta'],
                            'icono' => $page['icono']
                        ];
                    }
                }
            }

            return new ResponseDTO(200, $pages, null);
        } catch (\Exception $th) {
            return new ResponseDTO(500, null, 'Hubo un error al procesar la solicitud');
        }
    }

    public function getPermissionsByUsers(?string $username, ?string $email): ResponseDTO
    {
        try {
            $result = PageRepository::getPermissionsByUsers($username, $email);

            if (!$result) return new ResponseDTO(404, null, 'No se encontraron permisos para el usuario');

            return new ResponseDTO(200, $result, null);
        } catch (\Exception $ex) {
            return new ResponseDTO(500, null, $ex->getMessage() ?? 'Hubo un error al procesar la solicitud');
        }
    }

    public function getPermissionsByRoles(?string $rol): ResponseDTO
    {
        try {
            $result = PageRepository::getPermissionsByRoles($rol);

            if (!$result) return new ResponseDTO(404, null, 'No se encontraron permisos para el rol');

            return new ResponseDTO(200, $result, null);
        } catch (\Exception $ex) {
            return new ResponseDTO(500, null, $ex->getMessage() ?? 'Hubo un error al procesar la solicitud');
        }
    }
}
