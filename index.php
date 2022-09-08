<?php
session_start();
include('config.php');

spl_autoload_register( function ($className) {
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = strtolower(substr($className, 0, $lastNsPos));
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
});

if (!SHOW_ERRORS) {
    error_reporting(0);

    register_shutdown_function( function () {
        $error = error_get_last();
        if ($error && $error['type'] == E_ERROR) {
            http_response_code(500);
            include('views/errors/500.php');
        }
    });
}


if(!isset($_COOKIE['path']) && PATH_DIR) {
    setcookie('path', PATH_DIR . '/');
    $_COOKIE['path'] = PATH_DIR . '/';
}

include('routes.php');
