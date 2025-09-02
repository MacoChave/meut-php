<?php

namespace Repositories;

use PDO;
use PDOException;

class StatusRepository
{
    public function getDbStatus(): array
    {
        try {
            $pdo = require __DIR__ . "/../config/database.php";
            $stmt = $pdo->query("SELECT 1 as result");
            $row = $stmt->fetch();
            return ['database' => 'up', 'test' => $row['result']];
        } catch (PDOException $e) {
            return ['database' => 'down', 'error' => $e->getMessage()];
        }
    }
}
