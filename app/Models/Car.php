<?php
namespace App\Models;

use App\core\Database;
use PDO;

class Car
{
    public static function getAll(): array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->query("SELECT * FROM cars");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id): ?array
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("SELECT * FROM cars WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $car = $stmt->fetch(PDO::FETCH_ASSOC);
        return $car ?: null;
    }

    public static function create(array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "INSERT INTO cars (brand, model, year, fuel_type, license_plate, photo_path)
                VALUES (:brand, :model, :year, :fuel_type, :license_plate, :photo_path)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'brand'         => $data['brand'],
            'model'         => $data['model'],
            'year'          => $data['year'],
            'fuel_type'     => $data['fuel_type'],
            'license_plate' => $data['license_plate'],
            'photo_path'    => $data['photo_path']
        ]);
    }

    public static function update($id, array $data): bool
    {
        $pdo = Database::getInstance();
        $sql = "UPDATE cars
                SET brand = :brand, model = :model, year = :year, fuel_type = :fuel_type,
                    license_plate = :license_plate, photo_path = :photo_path
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            'id'            => $id,
            'brand'         => $data['brand'],
            'model'         => $data['model'],
            'year'          => $data['year'],
            'fuel_type'     => $data['fuel_type'],
            'license_plate' => $data['license_plate'],
            'photo_path'    => $data['photo_path'],
        ]);
    }

    public static function delete($id): bool
    {
        $pdo = Database::getInstance();
        $stmt = $pdo->prepare("DELETE FROM cars WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
