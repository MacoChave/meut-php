<?php

namespace Services;

use DTO\ResponseDTO;
use Exception;
use Repositories\ConstantRepository;

class ConstantService
{
    public function getConstants($id = null)
    {
        try {
            $result = [];

            if ($id)
                $result = ConstantRepository::getOne($id);
            else
                $result = ConstantRepository::getAll();

            if (!$result) return new ResponseDTO(404, null, "No se encontraron constantes");

            return new ResponseDTO(200, $result, null);
        } catch (Exception $ex) {
            return new ResponseDTO(500, null, $ex->getMessage());
        }
    }

    public function updateConstant($id, $name, $value)
    {
        try {
            $result = ConstantRepository::update($id, $name, $value);

            if (!$result) return new ResponseDTO(400, null, "No se pudo actualizar la constante");

            return new ResponseDTO(200, [], null);
        } catch (Exception $ex) {
            return new ResponseDTO(500, null, $ex->getMessage());
        }
    }
}
