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

    // Zobrazenie prihlasovacieho formulára
    public function login()
    {
        $this->startSession();
        require __DIR__ . '/../Views/pages/login.view.php';
    }

    // Spracovanie prihlásenia
    public function loginProcess()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Vyplňte všetky požadované polia.']);
            exit;
        }

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['username'] = $user['username'];

            echo json_encode(['success' => true, 'username' => $user['username']]); // ✅ Posielame používateľské meno
        } else {
            echo json_encode(['success' => false, 'error' => 'Nesprávne meno alebo heslo!']);
        }
        exit;
    }

    // Zobrazenie registračného formulára
    public function register()
    {
        $this->startSession();
        require __DIR__ . '/../Views/pages/register.view.php';
    }

    // Spracovanie registrácie
    public function registerProcess()
    {
        $this->startSession();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Kontrola prázdnych polí
        if (empty($username) || empty($password)) {
            header('Location: ?url=user/register&error=empty');
            exit;
        }

        // Kontrola dĺžky mena a hesla
        if (strlen($username) < 4 || strlen($username) > 20) {
            header('Location: ?url=user/register&error=username_length');
            exit;
        }
        if (strlen($password) < 6) {
            header('Location: ?url=user/register&error=password_length');
            exit;
        }

        // Kontrola, či užívateľ existuje
        if (User::findByUsername($username)) {
            header('Location: ?url=user/register&error=exists');
            exit;
        }

        // Vytvorenie nového používateľa
        $success = User::create($username, $password, 'user');

        if (!$success) {
            header('Location: ?url=user/register&error=db');
            exit;
        }

        // Automatické prihlásenie po registrácii
        $user = User::findByUsername($username);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = htmlspecialchars($username);

        header('Location: ?url=home/index&success=registered');
        exit;
    }

    // Odhlásenie používateľa
    public function logout()
    {
        $this->startSession();
        $_SESSION = [];
        session_destroy();

        // Ak je požiadavka AJAX, vrátime JSON
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['success' => true]);
            exit;
        }

        // Bežné presmerovanie pre štandardné požiadavky
        header('Location: ?url=home/index');
        exit;
    }

    // Získanie stavu prihlásenia
    public function status()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        header('Content-Type: application/json');

        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['loggedIn' => false]);
            exit;
        }

        echo json_encode([
            'loggedIn' => true,
            'username' => $_SESSION['username'],
            'role' => $_SESSION['role']
        ]);
        exit;
    }
}
