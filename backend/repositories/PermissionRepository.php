<?php

namespace Repositories;

use Helpers\Log;
use PDO;
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

    /**
     * Actualizar o guardar los permisos por rol
     */
    public static function savePermissionsByRole($idPagina, $idRol, $permissions)
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            // Llamar al procedimiento ut_sp_m_pagina_rol
            $stmt = $pdo->prepare('CALL ut_sp_m_pagina_rol(:id_pagina, :id_rol, :permissions)');

            $permissionJson = json_encode($permissions);

            $stmt->bindParam(':id_pagina', $idPagina, PDO::PARAM_INT);
            $stmt->bindParam(':id_rol', $idRol, PDO::PARAM_INT);
            $stmt->bindParam(':permissions', $permissionJson, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            Log::error($ex->getMessage(), ['class' => 'PermissionRepository', 'method' => 'savePermissionsByRole']);
            throw new \Exception("Error al guardar los permisos por rol", 1);
        }
    }

    /**
     * Actualizar o guardar los permisos por usuario
     */
    public static function savePermissionsByUser($idUsuario, $permissions)
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            // Llamar al procedimiento ut_sp_m_usuario_permiso
            $stmt = $pdo->prepare('CALL ut_sp_m_pagina_usuario(:id_pagina, :id_usuario, :permissions)');

            $permissionJson = json_encode($permissions);

            $stmt->bindParam(':id_pagina', $idPagina, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(':permissions', $permissionJson, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $ex) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            Log::error($ex->getMessage(), ['class' => 'PermissionRepository', 'method' => 'savePermissionsByUser']);
            throw new \Exception("Error al guardar los permisos por usuario", 1);
        }
    }
}
