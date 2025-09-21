<?php

namespace Repositories;

use Helpers\Log;
use PDOException;

class RolRepository
{
    public static function getAllRoles()
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare('SELECT * FROM rol');
            $stmt->execute();

            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'RolRepository', 'method' => 'getAllRoles']);
            throw new \Exception("Error al obtener los roles", 1);
        }
    }
}
