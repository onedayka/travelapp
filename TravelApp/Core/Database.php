<?php

namespace TravelApp\Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database {
    private static ?Connection $connection = null;

    private function __construct() {}

    /**
     * Получает подключение к базе данных. Если подключение не установлено, создает новое.
     *
     * @return Connection
     */
    public static function getConnection(): Connection {
        if (self::$connection === null) {
            self::$connection = self::createConnection();
        }
        return self::$connection;
    }

    /**
     * Создает новое подключение к базе данных с заданными параметрами.
     *
     * @return Connection
     */
    private static function createConnection(): Connection {
        $connectionParams = [
            'dbname' => 'travel',
            'user' => 'travel',
            'password' => 'travel',
            'host' => 'localhost',
            'driver' => 'pdo_mysql',
        ];

        return DriverManager::getConnection($connectionParams);
    }
}

?>