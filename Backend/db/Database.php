<?php

namespace db;

use PDO;

class Database
{
    public static function getConnection(): PDO
    {
        $pdo = new PDO("mysql:host=mysql;dbname=developmentdb", "developer", "secret123");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}
