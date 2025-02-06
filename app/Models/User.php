<?php
namespace App\Models;

use App\core\Database;
use PDO;
use PDOException;

class User
{
    // Nájde používateľa podľa mena
    public static function findByUsername(string $username): ?array
    {
        try {
            $pdo = Database::getInstance();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            return $user ?: null;
        } catch (PDOException $e) {
            error_log("Chyba DB v findByUsername: " . $e->getMessage());
            return null;
        }
    }

    // Vytvorenie nového používateľa
    public static function create(string $username, string $password, string $role = 'user'): bool
    {
        try {
            $pdo = Database::getInstance();

            // Kontrola duplicity (dodatočná ochrana na úrovni DB)
            if (self::findByUsername($username)) {
                return false; // Používateľ už existuje
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password, role) VALUES (:username, :password, :role)";
            $stmt = $pdo->prepare($sql);

            return $stmt->execute([
                ':username' => $username,
                ':password' => $hashedPassword,
                ':role'     => $role
            ]);
        } catch (PDOException $e) {
            error_log("Chyba DB v create: " . $e->getMessage());
            return false;
        }
    }
}
