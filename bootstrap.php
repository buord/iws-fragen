<?php

session_start();

require_once 'app/Libs/QueryBuilder.php';
require_once 'app/Libs/Database.php';
require_once 'app/Libs/Route.php';

call_user_func(function () {
    $env = explode(PHP_EOL, file_get_contents(__DIR__ . '/.env'));

    foreach ($env as $line) {
        list($key, $value) = explode('=', preg_replace('/#.*$/', '', $line));
        $key = trim($key);
        $value = trim($value);

        if ($key !== '' && $value !== '') {
            define($key, $value);
        }
    }
});

function view($path, $data = []) {
    require_once "views/$path.php";
}

function url($path) {
    if ($path[0] !== '/') {
        $path = '/' . $path;
    }

    return APP_DOMAIN . APP_BASEPATH . $path;
}

function escape($value) {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function create_token($length = 42) {
    return bin2hex(openssl_random_pseudo_bytes($length));
}

if (APP_ENV == 'local') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    function d($x) {
        echo '<pre>';
        print_r($x);
        echo '</pre>';
    }

    function dd($x) {
        d($x);
        die();
    }
} else {
    error_reporting(E_NONE);
    ini_set('display_errors', Off);
}