<?php
// public/index.php
require_once __DIR__ . '/../config/config.php'; // <-- чтобы взять define('APP_NAME', ...)
require __DIR__ . '/../vendor/autoload.php';

// Автозагрузчик классов (если нет Composer — пишем свой):
spl_autoload_register(function ($className) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Старт сессии (если надо)
session_start();

// Запуск роутера
use App\core\Router;

$router = new Router();
$router->run();
