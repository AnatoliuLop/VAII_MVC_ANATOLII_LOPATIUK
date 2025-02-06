<?php
namespace App\Models;

use App\core\Database;
use PDO;

class Instructor
{
    public static function getAll(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM instructors");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id): ?array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM instructors WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $instructor = $stmt->fetch(PDO::FETCH_ASSOC);
        return $instructor ?: null;
    }

    public static function create(array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO instructors (name, email, phone, specialization, photo_path,experience_years)
                VALUES (:name, :email, :phone, :specialization, :photo_path, :experience_years)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'name'          => $data['name'],
            'email'         => $data['email'],
            'phone'         => $data['phone'],
            'specialization'=> $data['specialization'],
            'photo_path'    => $data['photo_path'],
            'experience_years' =>$data['experience_years'] ?? 0
        ]);
    }

    public static function update($id, array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE instructors
            SET name = :name, email = :email, phone = :phone,
                specialization = :specialization, photo_path = :photo_path, experience_years = :experience_years
            WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'id'               => $id,
            'name'             => $data['name'],
            'email'            => $data['email'],
            'phone'            => $data['phone'],
            'specialization'   => $data['specialization'],
            'photo_path'       => $data['photo_path'],
            'experience_years' => $data['experience_years'] ?? 0
        ]);
    }

    public static function delete($id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM instructors WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
