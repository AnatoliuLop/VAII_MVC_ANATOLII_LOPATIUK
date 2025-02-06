<?php
namespace App\core;

class Router
{
    public function run()
    {
        $url = $_GET['url'] ?? 'home/index';
        $url = rtrim($url, '/');
        $parts = explode('/', $url);

        $controllerName = ucfirst($parts[0]) . 'Controller';
        $actionName = $parts[1] ?? 'index';

        $controllerClass = 'App\\Controllers\\' . $controllerName;

        // Presmerovanie na stránku "Zakázané"
        if ($url === 'forbidden') {
            $controllerObj = new \App\Controllers\HomeController();
            $controllerObj->forbidden();
            return;
        }

        if (class_exists($controllerClass)) {
            $controllerObj = new $controllerClass();

            // Kontrola, či metóda existuje v kontroléri
            if (method_exists($controllerObj, $actionName)) {
                $controllerObj->$actionName();
                return;
            }
        }

        // Spracovanie trasy pre formulár prihlásenia na kurz
        if ($controllerName === 'EnrollController' && in_array($actionName, ['form', 'enroll'])) {
            $controllerObj = new \App\Controllers\EnrollController();
            $controllerObj->$actionName();
            return;
        }

        // Presmerovanie na stav používateľa
        if ($url === 'user/status') {
            $controllerObj = new \App\Controllers\UserController();
            $controllerObj->status();
            return;
        }

        // Odhlásenie používateľa
        if ($url === 'user/logoutProcess') {
            $controllerObj = new \App\Controllers\UserController();
            $controllerObj->logoutProcess();
            return;
        }

        // 404 - Ak kontrolér alebo metóda nie sú nájdené
        http_response_code(404);
        echo "404 Not Found";
    }
}
