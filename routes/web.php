<?php
// routes/web.php

// Здесь можно прописать массив роутов, если хочешь вручную
// Но если используешь мой Router.php — он сам парсит ?url=controller/action

$routes = [
    // Пример: 'GET /cars' => 'CarController@index'
    //        'GET /car/create' => 'CarController@create'
    // и т.д.
];

// Потом в Router.php этот файл подключаешь и ищешь в $routes совпадения.
// Либо просто игнорируй, если используешь query-параметр ?url=...
