<?php
// public/index.php
require_once __DIR__ . '/../config/config.php';
require __DIR__ . '/../vendor/autoload.php';

//Automatické načítanie tried (ak nie je Composer — píšeme vlastné):
spl_autoload_register(function ($className) {
    $file = __DIR__ . '/../' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Spustenie relácie
session_start();

//Spustenie routera
use App\core\Router;

$router = new Router();
$router->run();
