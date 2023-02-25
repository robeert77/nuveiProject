<?php
require_once 'config.php';

use includes\Router;

spl_autoload_register(function ($className) {
    $filename = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
});

$router = new Router();
$router->renderContent();
