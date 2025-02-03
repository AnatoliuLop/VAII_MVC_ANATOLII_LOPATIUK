<?php
namespace App\Controllers;

use App\Models\Car;

class CarController
{
    public function index()
    {
        $cars = Car::getAll();
        require __DIR__ . '/../Views/pages/cars.view.php';
    }

    public function create()
    {
        require __DIR__ . '/../Views/pages/car_create.view.php';
    }

    public function store()
    {
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
                $photoDir = '/var/www/html/public/uploads/cars/';
                if (!is_dir($photoDir) && !mkdir($photoDir, 0777, true)) {
                    die('Chyba: nemožno vytvoriť adresár ' . $photoDir);
                }
                chmod($photoDir, 0777);
                chown($photoDir, 'www-data');

                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/cars/' . $filename;
                $targetFile = $photoDir . $filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    die('Chyba: súbor sa nepodarilo presunúť do ' . $targetFile);
                }
                chmod($targetFile, 0644);
            }

            Car::create([
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'fuel_type' => $fuelType,
                'license_plate' => $licensePlate,
                'photo_path' => $photoPath
            ]);

            $_SESSION['success'] = "Auto bolo úspešne pridané!";
            header('Location: ?url=car/index');
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $id = $_POST['id'] ?? null;
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
                $photoDir = '/var/www/html/public/uploads/cars/';
                if (!is_dir($photoDir) && !mkdir($photoDir, 0777, true)) {
                    die('Chyba: nemožno vytvoriť adresár ' . $photoDir);
                }
                chmod($photoDir, 0777);
                chown($photoDir, 'www-data');

                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/cars/' . $filename;
                $targetFile = $photoDir . $filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    die('Chyba: súbor sa nepodarilo presunúť do ' . $targetFile);
                }
                chmod($targetFile, 0644);
            }

            Car::update($id, [
                'brand' => $brand,
                'model' => $model,
                'year' => $year,
                'fuel_type' => $fuelType,
                'license_plate' => $licensePlate,
                'photo_path' => $photoPath
            ]);

            $_SESSION['success'] = "Auto bolo úspešne upravené!";
            header('Location: ?url=car/index');
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Car::delete($id);
        }
        $_SESSION['success'] = "Auto bolo úspešne vymazané!";
        header('Location: ?url=car/index');
    }
}
