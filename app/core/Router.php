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

        if (class_exists($controllerClass)) {
            $controllerObj = new $controllerClass();

            // Проверяем наличие метода в контроллере
            if (method_exists($controllerObj, $actionName)) {
                $controllerObj->$actionName();
                return;
            }
        }
// Обработка маршрута для формы заявки
        if ($controllerName === 'EnrollController' && in_array($actionName, ['form', 'enroll'])) {
            $controllerObj = new \App\Controllers\EnrollController();
            $controllerObj->$actionName();
            return;
        }

        // 404 - если контроллер или метод не найдены
        http_response_code(404);
        echo "404 Not Found";
    }
}
