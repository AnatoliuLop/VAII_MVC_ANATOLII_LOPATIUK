<?php
namespace App\Models;

use App\core\Database;
use PDO;

class Course
{
    public static function getAll(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM courses");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id): ?array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        return $course ?: null;
    }

    public static function create(array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO courses (title, description, full_description, duration, price, photo_path)
                VALUES (:title, :description, :full_description, :duration, :price, :photo_path)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'title'       => $data['title'],
            'description' => $data['description'],
            ':full_description' => $data['full_description'],
            'duration'    => $data['duration'],
            'price'       => $data['price'],
            'photo_path'  => $data['photo_path']
        ]);
    }

    public static function update($id, array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE courses
                SET title = :title, description = :description,full_description = :full_description, duration = :duration,
                    price = :price, photo_path = :photo_path
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'id'          => $id,
            'title'       => $data['title'],
            'description' => $data['description'],
            ':full_description' => $data['full_description'], // ✅ добавляем сюда
            'duration'    => $data['duration'],
            'price'       => $data['price'],
            'photo_path'  => $data['photo_path']
        ]);
    }

    public static function delete($id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
