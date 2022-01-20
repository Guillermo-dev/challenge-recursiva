<?php

if (isset($router)) {
    $router->get('/', 'controllers\Direct@index');

    $router->get('/data', 'controllers\Direct@showData');

    $router->set404('controllers\Direct@page404');
}
