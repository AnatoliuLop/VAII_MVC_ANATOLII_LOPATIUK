<?php
namespace App\Models;

use App\core\Database;
use PDO;

class User
{
    public static function findByUsername($username): ?array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public static function create($username, $password, $role = 'user'): bool
    {
        $pdo = Database::getInstance();
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password, role) VALUES (:u, :p, :r)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'u' => $username,
            'p' => $hashedPassword,
            'r' => $role
        ]);
    }
}
