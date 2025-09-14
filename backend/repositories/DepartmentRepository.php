<?php

namespace Repositories;

use DTO\ResponseDTO;
use Exception;
use PDO;
use PDOException;

class DepartmentRepository
{
    public static function getAll()
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT * FROM departamento");
            $stmt->execute();
            $department = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $department;
        } catch (PDOException $ex) {
            throw new Exception("Error al obtener el departamento", 1);
        }
    }
}
