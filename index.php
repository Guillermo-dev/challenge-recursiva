<?php

use Bramus\Router\Router;

include_once 'vendor/autoload.php';

$router = new Router();

include_once 'routes/web.php';


try {
    $router->run();   
} catch (Throwable $e) {
    header('HTTP/1.0 500 Internal Server Error');
    echo file_get_contents('src/pages/500/500.html');
}