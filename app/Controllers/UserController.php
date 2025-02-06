<?php
namespace App\Controllers;

use App\Models\User;

class UserController
{
    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Показать форму логина
    public function login()
    {
        $this->startSession();
        require __DIR__ . '/../Views/pages/login.view.php';
    }

    // Обработка сабмита формы логина
    public function loginProcess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            header('Location: ?url=user/login&error=empty_fields');
            exit;
        }

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            header('Location: ?url=home/index');
        } else {
            header('Location: ?url=user/login&error=invalid_credentials');
        }
        exit;
    }


    // Форма регистрации
    public function register()
    {
        $this->startSession();
        require __DIR__ . '/../Views/pages/register.view.php';
    }

    // Обработка регистрации
    public function registerProcess()
    {
        $this->startSession();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Проверка на пустые поля
        if (empty($username) || empty($password)) {
            header('Location: ?url=user/register&error=empty');
            exit;
        }

        // Проверка длины логина и пароля
        if (strlen($username) < 4 || strlen($username) > 20) {
            header('Location: ?url=user/register&error=username_length');
            exit;
        }
        if (strlen($password) < 6) {
            header('Location: ?url=user/register&error=password_length');
            exit;
        }

        // Проверка на наличие существующего пользователя
        if (User::findByUsername($username)) {
            header('Location: ?url=user/register&error=exists');
            exit;
        }


        // Создание нового пользователя
        $success = User::create($username, $password, 'user');

        if (!$success) {
            header('Location: ?url=user/register&error=db');
            exit;
        }

        // Автоматический вход после регистрации
        $user = User::findByUsername($username);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = htmlspecialchars($username);

        header('Location: ?url=home/index&success=registered');
        exit;
    }

    // Логаут
    public function logout()
    {
        $this->startSession();
        $_SESSION = [];
        session_destroy();
        header('Location: ?url=home/index');
        exit;
    }
}
