<?php

namespace Repositories;

use Helpers\Log;
use PDOException;

class PermissionRepository
{
    public static function getAllPermissions()
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare('SELECT * FROM ut_permiso');
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'PermissionRepository', 'method' => 'getAllPermissions']);
            throw new \Exception("Error al obtener los permisos", 1);
        }
    }
}
