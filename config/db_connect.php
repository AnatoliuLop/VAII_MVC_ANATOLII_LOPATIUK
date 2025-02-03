<?php
// config/db_connect.php

$host = 'db';
$db_name = 'autoschool';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR CONNECT TO DB  " . $e->getMessage());
}
