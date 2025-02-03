<?php
namespace App\Controllers;

use App\Models\User;

class UserController
{
    // Показать форму логина
    public function login()
    {
        // В шаблоне form action="?url=user/loginProcess"
        require __DIR__ . '/../Views/pages/login.view.php';
    }

    // Обработка сабмита формы логина
    public function loginProcess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        // Получаем логин/пароль из POST
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Модель User::findByUsername
        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Авторизация успешна
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['role']      = $user['role'];
            $_SESSION['username']  = $user['username']; // ← NEW
            header('Location: ?url=home/index');
        } else {
            // Ошибка логина
            header('Location: ?url=user/login&error=1');
        }
        exit;
    }
    // Форма регистрации (НОВЫЙ метод)
    public function register()
    {
        // Можно хранить любые session-статусы
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        // Подключаем шаблон с формой "register.view.php"
        require __DIR__ . '/../Views/pages/register.view.php';
    }

    // Обработка регистрации (НОВЫЙ метод)
    public function registerProcess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }


        // Получаем логин/пароль из POST
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // 1) Проверяем, не пусты ли поля
        if (empty($username) || empty($password)) {
            header('Location: ?url=user/register&error=empty');
            exit;
        }

        // 2) Проверяем, не существует ли пользователь
        $existingUser = User::findByUsername($username);
        if ($existingUser) {
            // Уже существует
            header('Location: ?url=user/register&error=exists');
            exit;
        }

        // 3) Создаём нового пользователя
        // По умолчанию role='user', если хочешь — поменяй
        $success = User::create($username, $password, 'user');
        if (!$success) {
            // Не смогли создать (редко, но бывает)
            header('Location: ?url=user/register&error=db');
            exit;
        }

        // 4) Можем сразу логинить его или отправить на логин
        // Например, сразу логиним:
        $_SESSION['user_id'] = User::findByUsername($username)['id'];
        $_SESSION['role'] = 'user';

        // Перенаправляем на главную (или куда хочешь)
        header('Location: ?url=home/index&success=registered');
        exit;
    }

    // Логаут (уже есть)
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_destroy();
        header('Location: ?url=home/index');
        exit;
    }
}
