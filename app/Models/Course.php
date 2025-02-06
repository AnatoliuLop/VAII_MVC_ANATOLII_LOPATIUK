<?php
namespace App\Models;

use App\core\Database;
use PDO;

class Course
{
    // Získa všetky kurzy spolu s menami inštruktorov
    public static function getAllWithInstructors(): array
    {
        $pdo = Database::getInstance();
        $sql = "SELECT courses.*, instructors.name AS instructor_name 
                FROM courses 
                LEFT JOIN instructors ON courses.instructor_id = instructors.id";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Získa zoznam všetkých inštruktorov
    public static function getInstructorsList(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT id, name FROM instructors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Nájde konkrétny kurz podľa ID
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

    // Vytvorí nový kurz
    public static function create(array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO courses (title, description, full_description, duration, price, photo_path, instructor_id)
                VALUES (:title, :description, :full_description, :duration, :price, :photo_path, :instructor_id)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($data);
    }

    // Aktualizuje existujúci kurz
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

    // Odstráni kurz podľa ID
    public static function delete($id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM courses WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
