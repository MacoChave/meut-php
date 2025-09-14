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
                CALL ut_sp_get_user_permissions(:idUser);
            ');
            $stmt->bindParam(':idUser', $idUser, PDO::PARAM_INT);
            $stmt->execute();

            $pages = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $pages;
        } catch (PDOException $ex) {
            Log::error($ex->getMessage(), ['class' => 'PageRepository', 'method' => 'getPagesWithPermissions']);
            throw new Exception("Error al obtener las páginas con permisos", 1);
        }
    }
}
