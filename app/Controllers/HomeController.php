<?php
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Просто подключаем View главной страницы
        require __DIR__ . '/../Views/pages/home.view.php';
    }

    // Пример метода:
    public function contact()
    {
        require __DIR__ . '/../Views/pages/contact.view.php';
    }

    public function about()
    {
        require __DIR__ . '/../Views/pages/about.view.php';
    }
    public function exams()
    {
        // Здесь подключаешь view для Skúšky:
        require __DIR__ . '/../Views/pages/exams.view.php';
    }
    public function forbidden()
    {
        http_response_code(403); // Устанавливаем код ошибки 403
        require __DIR__ . '/../Views/pages/forbidden.view.php';
    }
    // И т.д.
}
