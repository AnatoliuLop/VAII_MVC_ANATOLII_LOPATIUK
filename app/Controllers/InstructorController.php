<?php
namespace App\Controllers;

use App\Models\Instructor;

class InstructorController
{
    private function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function index()
    {
        $instructors = Instructor::getAll();
        require __DIR__ . '/../Views/pages/instructors.view.php';
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }
        require __DIR__ . '/../Views/pages/instructor_create.view.php';
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
            $specialization = htmlspecialchars(trim($_POST['specialization'] ?? ''));
            $experience_years = (int)($_POST['experience_years'] ?? 0);

            if (empty($name)) $errors[] = "Meno inštruktora je povinné!";
            if (!$email) $errors[] = "Neplatná emailová adresa!";
            if (empty($phone) || !preg_match('/^\+?\d{10,15}$/', $phone)) {
                $errors[] = "Neplatné telefónne číslo!";
            }
            if (empty($specialization)) $errors[] = "Špecializácia je povinná!";

            $photoPath = '';
            if (!empty($_FILES['photo']['tmp_name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $errors[] = "Povolené formáty obrázkov: JPEG, PNG, WebP.";
                }
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Súbor je príliš veľký! Maximálna veľkosť je 2MB.";
                }

                if (empty($errors)) {
                    $photoDir = 'uploads/instructors/';
                    if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
                    $filename = basename($_FILES['photo']['name']);
                    $photoPath = $photoDir . $filename;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=instructor/create');
                exit;
            }

            Instructor::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'specialization' => $specialization,
                'photo_path' => htmlspecialchars($photoPath),
                'experience_years' => $experience_years
            ]);

            $_SESSION['success'] = "Inštruktor bol úspešne pridaný!";
            header('Location: ?url=instructor/index');
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
            header('Location: ?url=instructor/index');
            exit;
        }

        $instructor = Instructor::find($id);
        if (!$instructor) {
            header("HTTP/1.0 404 Not Found");
            echo "Inštruktor s ID $id neexistuje!";
            exit;
        }
        require __DIR__ . '/../Views/pages/instructor_edit.view.php';
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
            $name = htmlspecialchars(trim($_POST['name'] ?? ''));
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
            $specialization = htmlspecialchars(trim($_POST['specialization'] ?? ''));
            $experience_years = (int)($_POST['experience_years'] ?? 0);
            $existingPhoto = $_POST['existing_photo'] ?? '';

            if (empty($name)) $errors[] = "Meno inštruktora je povinné!";
            if (!$email) $errors[] = "Neplatná emailová adresa!";
            if (empty($phone) || !preg_match('/^\+?\d{10,15}$/', $phone)) {
                $errors[] = "Neplatné telefónne číslo!";
            }
            if (empty($specialization)) $errors[] = "Špecializácia je povinná!";

            $photoPath = $existingPhoto;
            if (!empty($_FILES['photo']['tmp_name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $errors[] = "Povolené formáty obrázkov: JPEG, PNG, WebP.";
                }
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Súbor je príliš veľký! Maximálna veľkosť je 2MB.";
                }

                if (empty($errors)) {
                    $photoDir = 'uploads/instructors/';
                    if (!is_dir($photoDir)) mkdir($photoDir, 0777, true);
                    $filename = basename($_FILES['photo']['name']);
                    $photoPath = $photoDir . $filename;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
                }
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?url=instructor/edit&id=$id");
                exit;
            }

            Instructor::update($id, [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'specialization' => $specialization,
                'experience_years' => $experience_years,
                'photo_path' => htmlspecialchars($photoPath)
            ]);

            $_SESSION['success'] = "Inštruktor bol úspešne upravený!";
            header('Location: ?url=instructor/index');
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
            Instructor::delete($id);
            $_SESSION['success'] = "Inštruktor bol úspešne vymazaný!";
        } else {
            $_SESSION['errors'][] = "ID inštruktora chýba!";
        }
        header('Location: ?url=instructor/index');
        exit;
    }
}
