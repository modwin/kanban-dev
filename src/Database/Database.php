<?php

declare(strict_types=1);

namespace WPROG2\FinalProject\src\Database;

use PDO;

class Database
{
    private static ?PDO $instance = null;

    private function __construct() {}
    private function __clone() {}

    /**
     * @return PDO den enda möjliga PDO-instansen för varje HTTP-request.
     */
    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = getenv('KANBAN_DB_HOST') ?: '127.0.0.1';
            $name = getenv('KANBAN_DB_NAME') ?: '';
            $user = getenv('KANBAN_DB_USER') ?: '';
            $pass = getenv('KANBAN_DB_PASSWORD') ?: '';

            $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            self::$instance = new PDO($dsn, $user, $pass, $options);
        }

        return self::$instance;
    }
}