<?php
namespace App\core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $host = 'db';
            $db_name = 'autoschool';
            $username = 'root';
            $password = 'root';

            try {
                self::$instance = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Chyba pri pripájaní k databáze: " . $e->getMessage());
            }
        }
        return self::$instance;
    }
}
