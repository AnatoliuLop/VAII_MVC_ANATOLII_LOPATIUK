<?php
namespace App\Controllers;

use App\Models\Car;

class CarController
{
    private function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function index()
    {
        $cars = Car::getAll();
        require __DIR__ . '/../Views/pages/cars.view.php';
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }
        require __DIR__ . '/../Views/pages/car_create.view.php';
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $brand = trim($_POST['brand'] ?? '');
            $model = trim($_POST['model'] ?? '');
            $year = $_POST['year'] ?? null;
            $fuelType = trim($_POST['fuel_type'] ?? '');
            $licensePlate = trim($_POST['license_plate'] ?? '');

            if (empty($brand)) $errors[] = "Značka auta je povinná!";
            if (empty($model)) $errors[] = "Model auta je povinný!";
            if (empty($year) || !is_numeric($year) || $year < 1900 || $year > date('Y')) {
                $errors[] = "Rok výroby musí byť medzi 1900 a " . date('Y');
            }
            if (empty($fuelType)) $errors[] = "Typ paliva je povinný!";
            if (empty($licensePlate)) $errors[] = "Evidenčné číslo je povinné!";

            $photoPath = '';
            if (!empty($_FILES['photo']['tmp_name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $errors[] = "Povolené formáty obrázkov: JPEG, PNG, WebP.";
                }
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Súbor je príliš veľký! Maximálna veľkosť je 2MB.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=car/create');
                exit;
            }

            if (!empty($_FILES['photo']['tmp_name'])) {
                $photoDir = 'uploads/cars/';
                if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
                $filename = basename($_FILES['photo']['name']);
                $photoPath = $photoDir . $filename;
                move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
            }

            Car::create([
                'brand' => htmlspecialchars($brand),
                'model' => htmlspecialchars($model),
                'year' => (int)$year,
                'fuel_type' => htmlspecialchars($fuelType),
                'license_plate' => htmlspecialchars($licensePlate),
                'photo_path' => htmlspecialchars($photoPath)
            ]);

            $_SESSION['success'] = "Auto bolo úspešne pridané!";
            header('Location: ?url=car/index');
        }
    }

    public function edit()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: ?url=car/index');
            exit;
        }

        $car = Car::find($id);
        if (!$car) {
            header("HTTP/1.0 404 Not Found");
            echo "Auto s ID $id neexistuje!";
            exit;
        }

        require __DIR__ . '/../Views/pages/car_edit.view.php';
    }

    public function update()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $id = (int)($_POST['id'] ?? 0);
            $brand = trim($_POST['brand'] ?? '');
            $model = trim($_POST['model'] ?? '');
            $year = $_POST['year'] ?? null;
            $fuelType = trim($_POST['fuel_type'] ?? '');
            $licensePlate = trim($_POST['license_plate'] ?? '');
            $existingPhoto = $_POST['existing_photo'] ?? '';

            if (empty($brand)) $errors[] = "Značka auta je povinná!";
            if (empty($model)) $errors[] = "Model auta je povinný!";
            if (empty($year) || !is_numeric($year) || $year < 1900 || $year > date('Y')) {
                $errors[] = "Rok výroby musí byť medzi 1900 a " . date('Y');
            }
            if (empty($fuelType)) $errors[] = "Typ paliva je povinný!";
            if (empty($licensePlate)) $errors[] = "Evidenčné číslo je povinné!";

            $photoPath = $existingPhoto;
            if (!empty($_FILES['photo']['tmp_name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $errors[] = "Povolené formáty obrázkov: JPEG, PNG, WebP.";
                }
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Súbor je príliš veľký! Maximálna veľkosť je 2MB.";
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=car/edit&id=' . $id);
                exit;
            }

            if (!empty($_FILES['photo']['tmp_name'])) {
                $photoDir = 'uploads/cars/';
                if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
                $filename = basename($_FILES['photo']['name']);
                $photoPath = $photoDir . $filename;
                move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
            }

            Car::update($id, [
                'brand' => htmlspecialchars($brand),
                'model' => htmlspecialchars($model),
                'year' => (int)$year,
                'fuel_type' => htmlspecialchars($fuelType),
                'license_plate' => htmlspecialchars($licensePlate),
                'photo_path' => htmlspecialchars($photoPath)
            ]);

            $_SESSION['success'] = "Auto bolo úspešne upravené!";
            header('Location: ?url=car/index');
        }
    }

    public function delete()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);
        if ($id) {
            Car::delete($id);
            $_SESSION['success'] = "Auto bolo úspešne vymazané!";
        }
        header('Location: ?url=car/index');
    }
}
