<?php
namespace App\Config;

final class Database
{
    private static ?\mysqli $conn = null;

    public static function connection(): \mysqli
    {
        if (self::$conn === null) {
            $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            $conn = mysqli_connect(
                $_ENV['HOSTNAME'],
                $_ENV['USERNAME'],
                $_ENV['PASSWORD'],
                $_ENV['DBNAME']
            );

            if (!$conn) {
                throw new \RuntimeException('DB: ' . mysqli_connect_error());
            }

            self::$conn = $conn;
        }

        return self::$conn;
    }
}