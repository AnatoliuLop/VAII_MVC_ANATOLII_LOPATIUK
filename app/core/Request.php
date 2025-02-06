<?php
namespace App\core;

class Request
{
    // Získa hodnotu z GET požiadavky, ak neexistuje, vráti predvolenú hodnotu
    public static function get($key, $default = null) {
        return $_GET[$key] ?? $default;
    }

    // Získa hodnotu z POST požiadavky, ak neexistuje, vráti predvolenú hodnotu
    public static function post($key, $default = null) {
        return $_POST[$key] ?? $default;
    }

    // Získa nahraný súbor zo žiadosti
    public static function file($key) {
        return $_FILES[$key] ?? null;
    }
}
