<?php

namespace Repositories;

use Exception;
use Helpers\Log;
use PDO;
use PDOException;

class MunicipalityRepository
{
    public static function getAll()
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT * FROM municipio");
            $stmt->execute();
            $department = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $department;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage());
            throw new Exception("Error al obtener los municipios", 1);
        }
    }

    public static function getByDepartment(int $id_department)
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT * FROM municipio WHERE id_departamento = :id_department");
            $stmt->execute([":id_department" => $id_department]);
            $municipalities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $municipalities;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage());
            throw new Exception("Error al obtener los municipios", 1);
        }
    }
}
