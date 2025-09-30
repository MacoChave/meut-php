<?php

namespace Repositories;

use Exception;
use Helpers\Log;
use PDO;
use PDOException;

class ConstantRepository
{
    public static function getAll()
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT * FROM ut_constants");
            $stmt->execute();
            $constants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $constants;
        } catch (PDOException $ex) {
            Log::error("Error al obtener las constantes: " . $ex->getMessage());
            throw new Exception("Error al obtener las constantes", 1);
        }
    }

    public static function getOne($id)
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("SELECT * FROM ut_constants WHERE id_constant = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $constant = $stmt->fetch(PDO::FETCH_ASSOC);

            return $constant;
        } catch (PDOException $ex) {
            Log::error("Error al obtener la constante: " . $ex->getMessage());
            throw new Exception("Error al obtener la constante", 1);
        }
    }

    public static function update($id, $name, $value)
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";

            $stmt = $pdo->prepare("UPDATE ut_constants SET nombre = :name, valor = :value WHERE id_constant = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':value', $value);
            $stmt->execute();

            return true;
        } catch (PDOException $ex) {
            Log::error("Error al actualizar la constante: " . $ex->getMessage());
            throw new Exception("Error al actualizar la constante", 1);
        }
    }
}
