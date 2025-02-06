<?php
namespace App\Models;

use App\core\Database;
use PDO;

class Course
{
    public static function getAllWithInstructors(): array
    {
        $pdo = Database::getInstance();
        $sql = "SELECT courses.*, instructors.name AS instructor_name 
                FROM courses 
                LEFT JOIN instructors ON courses.instructor_id = instructors.id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getInstructorsList(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id, name FROM instructors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id): ?array
    {
        $pdo = Database::getInstance();
        $sql = "SELECT courses.*, instructors.name AS instructor_name 
                FROM courses 
                LEFT JOIN instructors ON courses.instructor_id = instructors.id
                WHERE courses.id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $course = $stmt->fetch(PDO::FETCH_ASSOC);
        return $course ?: null;
    }

    public static function create(array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO courses (title, description, full_description, duration, price, photo_path, instructor_id)
                VALUES (:title, :description, :full_description, :duration, :price, :photo_path, :instructor_id)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($data);
    }

    public static function update($id, array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE courses 
                SET title = :title, description = :description, full_description = :full_description, duration = :duration,
                    price = :price, photo_path = :photo_path, instructor_id = :instructor_id
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(array_merge(['id' => $id], $data));
    }

    public static function delete($id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
