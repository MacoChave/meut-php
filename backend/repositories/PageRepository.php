<?php

namespace Repositories;

use Exception;
use Helpers\Log;
use PDO;
use PDOException;

class PageRepository
{
    public static function getAll()
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare('SELECT * FROM ut_pagina');
            $stmt->execute();

            $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $pages;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'PageRepository', 'method' => 'getAll']);
            throw new Exception("Error al obtener las páginas", 1);
        }
    }

    public static function getPagesWithPermissions(int $idUser)
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare('
                CALL ut_sp_get_user_permissions(
                    :vista, :idUser
                    , :rol, :usuario, :correo 
                );
            ');
            $stmt->bindValue(':vista', 'P', PDO::PARAM_STR);
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->bindValue(':rol', null, PDO::PARAM_NULL);
            $stmt->bindValue(':usuario', null, PDO::PARAM_NULL);
            $stmt->bindValue(':correo', null, PDO::PARAM_NULL);

            $stmt->execute();

            $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $pages;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'PageRepository', 'method' => 'getPagesWithPermissions']);
            throw new Exception("Error al obtener las páginas con permisos", 1);
        }
    }

    public static function getPermissionsByUsers(?string $username, ?string $email)
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare('
                CALL ut_sp_get_user_permissions(
                    :vista, :idUser
                    , :rol, :usuario, :correo 
                );
            ');
            $stmt->bindValue(':vista', 'U', PDO::PARAM_STR);
            $stmt->bindValue(':idUser', null, PDO::PARAM_NULL);
            $stmt->bindValue(':rol', null, PDO::PARAM_NULL);
            $stmt->bindParam(':usuario', $username, PDO::PARAM_STR);
            $stmt->bindParam(':correo', $email, PDO::PARAM_STR);

            $stmt->execute();

            $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $permissions;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'PageRepository', 'method' => 'getPermissionsByUsers']);
            throw new Exception("Error al obtener los permisos por usuario", 1);
        }
    }

    public static function getPermissionsByRoles(?string $rol)
    {
        try {
            $pdo = require __DIR__ . '/../config/database.php';

            $stmt = $pdo->prepare('
                CALL ut_sp_get_user_permissions(
                    :vista, :idUser
                    , :rol, :usuario, :correo 
                );
            ');
            $stmt->bindValue(':vista', 'R', PDO::PARAM_STR);
            $stmt->bindValue(':idUser', null, PDO::PARAM_NULL);
            $stmt->bindParam(':rol', $rol, PDO::PARAM_STR);
            $stmt->bindValue(':usuario', null, PDO::PARAM_NULL);
            $stmt->bindValue(':correo', null, PDO::PARAM_NULL);

            $stmt->execute();

            $permissions = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $permissions;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'PageRepository', 'method' => 'getPermissionsByRoles']);
            throw new Exception("Error al obtener los permisos por rol", 1);
        }
    }
}
