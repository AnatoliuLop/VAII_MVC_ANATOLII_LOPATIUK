<?php
namespace App\Controllers;

class HomeController
{
    // Zobrazenie hlavnej stránky
    public function index()
    {
        require __DIR__ . '/../Views/pages/home.view.php';
    }

    // Stránka s kontaktnými informáciami
    public function contact()
    {
        require __DIR__ . '/../Views/pages/contact.view.php';
    }

    // Stránka "O nás"
    public function about()
    {
        require __DIR__ . '/../Views/pages/about.view.php';
    }

    // Stránka so skúškami
    public function exams()
    {
        require __DIR__ . '/../Views/pages/exams.view.php';
    }

    // Stránka s chybou 403 - Zakázaný prístup
    public function forbidden()
    {
        http_response_code(403);
        require __DIR__ . '/../Views/pages/forbidden.view.php';
    }
}
