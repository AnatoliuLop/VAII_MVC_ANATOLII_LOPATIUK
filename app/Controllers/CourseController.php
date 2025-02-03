<?php
namespace App\Controllers;

use App\Models\Course;

class CourseController
{
    public function index()
    {
        $courses = Course::getAll();
        require __DIR__ . '/../Views/pages/courses.view.php';
    }

    public function create()
    {
        require __DIR__ . '/../Views/pages/course_create.view.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            // Читаем данные из POST-запроса
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $fullDescription = trim($_POST['full_description'] ?? '');
            $duration = $_POST['duration'] ?? 0;
            $price = $_POST['price'] ?? 0;

            // Проверяем, что поля не пустые
            if (empty($title)) $errors[] = "Názov kurzu je povinný!";
            if (empty($description)) $errors[] = "Krátky popis je povinný!";
            if (empty($fullDescription)) $errors[] = "Celý popis kurzu je povinný!";
            if ($duration <= 0) $errors[] = "Trvanie musí byť viac ako 0 dní!";
            if ($price < 0) $errors[] = "Cena nemôže byť záporná!";

            // Если есть ошибки, отправляем пользователя обратно
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=course/create');
                exit;
            }

            // Обрабатываем фото
            $photoPath = '';
            if (!empty($_FILES['photo']['tmp_name'])) {
                $photoDir = '/var/www/html/public/uploads/courses/';
                if (!is_dir($photoDir) && !mkdir($photoDir, 0777, true)) {
                    die('Chyba: nemožno vytvoriť adresár ' . $photoDir);
                }
                chmod($photoDir, 0777);
                chown($photoDir, 'www-data');

                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/courses/' . $filename;
                $targetFile = $photoDir . $filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    die('Chyba: súbor sa nepodarilo presunúť do ' . $targetFile);
                }
                chmod($targetFile, 0644);
            }

            // Записываем в базу
            Course::create([
                'title' => $title,
                'description' => $description,
                'full_description' => $fullDescription,
                'duration' => $duration,
                'price' => $price,
                'photo_path' => $photoPath
            ]);

            $_SESSION['success'] = "Kurz bol úspešne pridaný!";
            header('Location: ?url=course/index');
        }
    }


    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?url=course/index');
            exit;
        }
        $course = Course::find($id);
        require __DIR__ . '/../Views/pages/course_edit.view.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];

            $id = $_POST['id'] ?? null;
            $title = trim($_POST['title'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $fullDescription = trim($_POST['full_description'] ?? '');
            $duration = $_POST['duration'] ?? 0;
            $price = $_POST['price'] ?? 0;
            $existingPhoto = $_POST['existing_photo'] ?? '';

            // Проверяем поля
            if (empty($title)) $errors[] = "Názov kurzu je povinný!";
            if (empty($description)) $errors[] = "Krátky popis je povinný!";
            if (empty($fullDescription)) $errors[] = "Celý popis kurzu je povinný!";
            if ($duration <= 0) $errors[] = "Trvanie musí byť viac ako 0 dní!";
            if ($price < 0) $errors[] = "Cena nemôže byť záporná!";

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?url=course/edit&id=$id");
                exit;
            }

            // Обрабатываем загрузку нового фото
            $photoPath = $existingPhoto;
            if (!empty($_FILES['photo']['tmp_name'])) {
                $photoDir = '/var/www/html/public/uploads/courses/';
                if (!is_dir($photoDir) && !mkdir($photoDir, 0777, true)) {
                    die('Chyba: nemožno vytvoriť adresár ' . $photoDir);
                }
                chmod($photoDir, 0777);
                chown($photoDir, 'www-data');

                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/courses/' . $filename;
                $targetFile = $photoDir . $filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    die('Chyba: súbor sa nepodarilo presunúť do ' . $targetFile);
                }
                chmod($targetFile, 0644);
            }

            // Обновляем курс
            Course::update($id, [
                'title' => $title,
                'description' => $description,
                'full_description' => $fullDescription,
                'duration' => $duration,
                'price' => $price,
                'photo_path' => $photoPath
            ]);

            $_SESSION['success'] = "Kurz bol úspešne upravený!";
            header('Location: ?url=course/index');
        }
    }

    public function details()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "Chýba ID kurzu"]);
            return;
        }

        $course = Course::find($id);
        if (!$course) {
            http_response_code(404);
            echo json_encode(["error" => "Kurz nebol nájdený"]);
            return;
        }

        header('Content-Type: application/json');
        echo json_encode([
            'title' => $course['title'],
            'full_description' => $course['full_description']
        ]);
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Course::delete($id);  // Удаление курса из базы данных
            $_SESSION['success'] = "Kurz bol úspešne vymazaný!";
        } else {
            $_SESSION['errors'][] = "ID kurzu chýba!";
        }
        header('Location: ?url=course/index');  // Перенаправление после удаления
        exit;
    }

}

// Включаем передачу ошибок и успехов в JavaScript
if (!empty($_SESSION['errors']) || !empty($_SESSION['success'])):
    $errorsJson = !empty($_SESSION['errors']) ? json_encode($_SESSION['errors']) : '[]';
    $successMsg = $_SESSION['success'] ?? '';
    unset($_SESSION['errors'], $_SESSION['success']);
    ?>
    <script>
        document.body.dataset.errors = <?= $errorsJson ?>;
        document.body.dataset.success = "<?= addslashes($successMsg) ?>";
    </script>
<?php endif; ?>
