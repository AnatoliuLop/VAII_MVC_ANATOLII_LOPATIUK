<?php
namespace App\Controllers;

use App\Models\Course;

class CourseController
{
    private function isAdmin()
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function index()
    {
        $courses = Course::getAllWithInstructors();
        require __DIR__ . '/../Views/pages/courses.view.php';
    }

    public function create()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }
        $instructors = Course::getInstructorsList(); // Загружаем всех инструкторов

        require __DIR__ . '/../Views/pages/course_create.view.php';
    }

    public function store()
    {
        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $fullDescription = trim($_POST['full_description'] ?? '');
            $duration = (int)($_POST['duration'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $instructor_id = isset($_POST['instructor_id']) ? (int)$_POST['instructor_id'] : null; // ✅ Исправлено

            if (empty($title)) $errors[] = "Názov kurzu je povinný!";
            if (empty($description)) $errors[] = "Krátky popis je povinný!";
            if (empty($fullDescription)) $errors[] = "Celý popis kurzu je povinný!";
            if ($duration <= 0) $errors[] = "Trvanie musí byť viac ako 0 dní!";
            if ($price < 0) $errors[] = "Cena nemôže byť záporná!";
            if (!$instructor_id || $instructor_id <= 0) $errors[] = "Musíte vybrať inštruktora!"; // ✅ Добавлена проверка

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=course/create');
                exit;
            }

            $photoPath = '';
            if (!empty($_FILES['photo']['tmp_name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $errors[] = "Povolené formáty obrázkov: JPEG, PNG, WebP.";
                }
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Súbor je príliš veľký! Maximálna veľkosť je 2MB.";
                }

                if (!is_dir('uploads/courses/')) {
                    mkdir('uploads/courses/', 0777, true);
                }
                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/courses/' . $filename;
                move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
            }

            Course::create([
                'title' => $title,
                'description' => $description,
                'full_description' => $fullDescription,
                'duration' => $duration,
                'price' => $price,
                'photo_path' => htmlspecialchars($photoPath),
                'instructor_id' => $instructor_id // ✅ Теперь instructor_id передаётся корректно
            ]);

            $_SESSION['success'] = "Kurz bol úspešne pridaný!";
            header('Location: ?url=course/index');
        }
    }


    public function edit()
    {

        if (!$this->isAdmin()) {
            header('Location: ?url=forbidden');
            exit;
        }
        $instructors = Course::getInstructorsList(); // Загружаем всех инструкторов

        $id = (int)($_GET['id'] ?? 0);
        if (!$id) {
            header('Location: ?url=course/index');
            exit;
        }
        $course = Course::find($id);
        if (!$course) {
            header("HTTP/1.0 404 Not Found");
            echo "Kurz s ID $id neexistuje!";
            exit;
        }
        require __DIR__ . '/../Views/pages/course_edit.view.php';
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
            $title = htmlspecialchars(trim($_POST['title'] ?? ''));
            $description = htmlspecialchars(trim($_POST['description'] ?? ''));
            $fullDescription = htmlspecialchars(trim($_POST['full_description'] ?? ''));
            $duration = (int)($_POST['duration'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $existingPhoto = $_POST['existing_photo'] ?? '';
            $instructor_id = (int)($_POST['instructor_id'] ?? 1);

            // ✅ Проверка, существует ли выбранный инструктор
            $instructors = array_column(Course::getInstructorsList(), 'id');
            if (!in_array($instructor_id, $instructors)) {
                $errors[] = "Vybraný inštruktor neexistuje!";
            }
            if (empty($title)) $errors[] = "Názov kurzu je povinný!";
            if (empty($description)) $errors[] = "Krátky popis je povinný!";
            if (empty($fullDescription)) $errors[] = "Celý popis kurzu je povinný!";
            if ($duration <= 0) $errors[] = "Trvanie musí byť viac ako 0 dní!";
            if ($price < 0) $errors[] = "Cena nemôže byť záporná!";

            $photoPath = $existingPhoto;
            if (!empty($_FILES['photo']['tmp_name'])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
                if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
                    $errors[] = "Povolené formáty obrázkov: JPEG, PNG, WebP.";
                }
                if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                    $errors[] = "Súbor je príliš veľký! Maximálna veľkosť je 2MB.";
                }

                if (!is_dir('uploads/courses/')) {
                    mkdir('uploads/courses/', 0777, true);
                }
                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/courses/' . $filename;
                move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?url=course/edit&id=$id");
                exit;
            }

            Course::update($id, [
                'title' => $title,
                'description' => $description,
                'full_description' => $fullDescription,
                'duration' => $duration,
                'price' => $price,
                'photo_path' => htmlspecialchars($photoPath),
                'instructor_id' => $instructor_id
            ]);

            $_SESSION['success'] = "Kurz bol úspešne upravený!";
            header('Location: ?url=course/index');
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
            Course::delete($id);
            $_SESSION['success'] = "Kurz bol úspešne vymazaný!";
        } else {
            $_SESSION['errors'][] = "ID kurzu chýba!";
        }
        header('Location: ?url=course/index');
        exit;
    }

    public function details()
    {
        if (!isset($_GET['id'])) {
            echo json_encode(['error' => 'Chýbajúce ID kurzu']);
            exit;
        }

        $id = (int) $_GET['id'];
        $course = Course::find($id);

        if (!$course) {
            echo json_encode(['error' => 'Kurz neexistuje']);
            exit;
        }

        header('Content-Type: application/json');
        echo json_encode($course);
    }

}
