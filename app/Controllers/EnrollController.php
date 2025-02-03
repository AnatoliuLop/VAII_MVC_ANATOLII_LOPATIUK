<?php
namespace App\Controllers;

use App\Models\Course;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EnrollController
{
    // Страница формы заявки
    public function form()
    {
        $courseId = $_GET['course_id'] ?? null;
        $course = Course::find($courseId); // Получаем данные о курсе

        if (!$course) {
            http_response_code(404);
            echo "Kurz nebol nájdený";
            return;
        }

        require __DIR__ . '/../Views/pages/enroll_form.view.php';
    }

    // Обработка заявки
    public function enroll()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $errors = [];

            $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
            $phone = trim($_POST['phone'] ?? '');
            $message = trim($_POST['message'] ?? '');
            $courseId = $_POST['course_id'] ?? null;

            if (!$email) $errors[] = "Neplatný email!";
            if (empty($phone) || !preg_match('/^\+?[0-9\s\-]{7,15}$/', $phone)) {
                $errors[] = "Zadajte platné telefónne číslo!";
            }
            if (empty($message)) $errors[] = "Správa nesmie byť prázdna!";
            if (!$courseId) $errors[] = "Kurz nebol identifikovaný.";

            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                header("Location: ?url=enroll/form&course_id=$courseId");
                exit;
            }
            // 📋 Получаем данные о курсе
            $course = Course::find($courseId);
            if (!$course) {
                $_SESSION['errors'][] = "Kurz nebol nájdený.";
                header('Location: ?url=course/index');
                exit;
            }

            $templates = [
                'Kategória A' => "Budete sa učiť jazdiť na motocykloch s obsahom do 125 cm³. Získate zručnosti pre bezpečnú jazdu v meste aj na diaľnici.",
                'Kategória B' => "Kurz zahŕňa výučbu jazdy na osobných automobiloch, vrátane parkovania, diaľničnej jazdy a riešenia krizových situácií.",
                'Kategória C' => "Tento kurz Vás pripraví na riadenie nákladných vozidiel vrátane manipulácie s veľkými nákladmi a bezpečnej jazdy na dlhé vzdialenosti.",
                'Kategória A+B' => "Ziskate Zlavy!.",

            ];
// Используем шаблон для выбранного курса или стандартный текст
            $courseTemplate = $templates[$course['title']] ?? "Tento kurz Vám poskytne základné zručnosti a znalosti potrebné pre úspešné zvládnutie skúšky.";
            // Отправка email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'lopatyuk.tolik@gmail.com';
                $mail->Password = 'dcha wxhz pasc xwti';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->CharSet = 'UTF-8'; // 🗝️ ВАЖЛИВО: додаємо для правильного кодування

                $mail->setFrom($email, 'Záujemca o kurz');
                $mail->addAddress('tvoj_email@gmail.com');

                $mail->Subject = "Nová žiadosť o kurz (ID: $courseId)";
                $mail->Body = "Používateľ s emailom: $email, telefónom: $phone poslal nasledujúcu správu:\n\n$message";

                $mail->send();
                $_SESSION['success'] = "Vaša žiadosť bola úspešne odoslaná!";

                // 📤 Автоматический ответ пользователю
                $autoReply = new PHPMailer(true);
                $autoReply->isSMTP();
                $autoReply->Host = 'smtp.gmail.com';
                $autoReply->SMTPAuth = true;
                $autoReply->Username = 'lopatyuk.tolik@gmail.com';
                $autoReply->Password = 'dcha wxhz pasc xwti';
                $autoReply->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $autoReply->Port = 587;
                $autoReply->CharSet = 'UTF-8';

                $autoReply->setFrom('lopatyuk.tolik@gmail.com', 'Autoškola ');
                $autoReply->addAddress($email);

                $autoReply->Subject = "Ďakujeme za záujem o kurz: " . $course['title'];
                $autoReply->Body = "Dobrý deň,\n\n"
                    . "Ďakujeme, že ste prejavili záujem o náš kurz: " . $course['title'] . ".\n\n"
                    . "📝 Základné informácie o kurze:\n"
                    . $courseTemplate . "\n\n"
                    . "Trvanie: " . $course['duration'] . " dní\n"
                    . "Cena: " . $course['price'] . " €\n\n"
                    . "Budeme Vás čoskoro kontaktovať s ďalšími detailmi.\n\n"
                    . "S pozdravom,\nTím Autoškola ";

                $autoReply->send();

                $_SESSION['success'] = "Vaša žiadosť bola úspešne odoslaná!";
            } catch (Exception $e) {
                $_SESSION['errors'][] = "Chyba pri odosielaní emailu: " . $mail->ErrorInfo;
            }

            header('Location: ?url=course/index');
        }
    }
}
