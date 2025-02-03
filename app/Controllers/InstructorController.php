<?php
namespace App\Controllers;

use App\Models\Instructor;

class InstructorController
{
    public function index()
    {
        $instructors = Instructor::getAll();
        require __DIR__ . '/../Views/pages/instructors.view.php';
    }

    public function create()
    {
        require __DIR__ . '/../Views/pages/instructor_create.view.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $specialization = trim($_POST['specialization'] ?? '');

            // Валидация полей
            if (empty($name)) $errors[] = "Meno inštruktora je povinné!";
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Neplatná emailová adresa!";
            }
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
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=instructor/create');
                exit;
            }

            if (!empty($_FILES['photo']['tmp_name'])) {
                $photoDir = '/var/www/html/public/uploads/instructors/';
                if (!is_dir($photoDir) && !mkdir($photoDir, 0777, true)) {
                    die('Chyba: nemožno vytvoriť adresár ' . $photoDir);
                }
                chmod($photoDir, 0777);
                chown($photoDir, 'www-data');

                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/instructors/' . $filename;
                $targetFile = $photoDir . $filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    die('Chyba: súbor sa nepodarilo presunúť do ' . $targetFile);
                }
                chmod($targetFile, 0644);
            }

            Instructor::create([
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'specialization' => $specialization,
                'photo_path' => $photoPath
            ]);

            $_SESSION['success'] = "Inštruktor bol úspešne pridaný!";
            header('Location: ?url=instructor/index');
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?url=instructor/index');
            exit;
        }
        $instructor = Instructor::find($id);
        require __DIR__ . '/../Views/pages/instructor_edit.view.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $specialization = trim($_POST['specialization'] ?? '');
            $existingPhoto = $_POST['existing_photo'] ?? '';

            // Валидация полей
            if (empty($name)) $errors[] = "Meno inštruktora je povinné!";
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Neplatná emailová adresa!";
            }
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
            }

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header('Location: ?url=instructor/edit&id=' . $id);
                exit;
            }

            if (!empty($_FILES['photo']['tmp_name'])) {
                $photoDir = '/var/www/html/public/uploads/instructors/';
                if (!is_dir($photoDir) && !mkdir($photoDir, 0777, true)) {
                    die('Chyba: nemožno vytvoriť adresár ' . $photoDir);
                }
                chmod($photoDir, 0777);
                chown($photoDir, 'www-data');

                $filename = basename($_FILES['photo']['name']);
                $photoPath = 'uploads/instructors/' . $filename;
                $targetFile = $photoDir . $filename;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile)) {
                    die('Chyba: súbor sa nepodarilo presunúť do ' . $targetFile);
                }
                chmod($targetFile, 0644);
            }

            Instructor::update($id, [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'specialization' => $specialization,
                'photo_path' => $photoPath
            ]);

            $_SESSION['success'] = "Inštruktor bol úspešne upravený!";
            header('Location: ?url=instructor/index');
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            Instructor::delete($id);
        }
        $_SESSION['success'] = "Inštruktor bol úspešne vymazaný!";
        header('Location: ?url=instructor/index');
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
