<?php

namespace Services;

use DTO\ResponseDTO;
use Helpers\Log;
use Repositories\DepartmentRepository;
use Repositories\MunicipalityRepository;

class LocationService
{
    public function getDepartments(): ResponseDTO
    {
        try {
            $result = DepartmentRepository::getAll();

            if (!$result) {
                return new ResponseDTO(404, null, "No se encontraron departamentos");
            }

            return new ResponseDTO(200, $result, null);
        } catch (\Exception $ex) {
            return new ResponseDTO(500, null, $ex->getMessage());
        }
    }

    public function getMunicipalities(?int $id_department = null): ResponseDTO
    {
        try {
            $result = !$id_department ? MunicipalityRepository::getAll() : MunicipalityRepository::getByDepartment($id_department);

            if (!$result) return new ResponseDTO(404, null, "No se encontraron municipios");

            return new ResponseDTO(200, $result ?? [], null);
        } catch (\Exception $ex) {
            return new ResponseDTO(500, null, $ex->getMessage());
        }
    }
}
