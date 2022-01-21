<?php

use api\util\Response;

if (isset($router)) {
    $router->setBasePath('/api');

    $router->post('/procesarArchivo', 'api\Archivos@procesarArchivo');

    $router->get('/data', 'api\Archivos@getData');

    $router->set404(function () {
        Response::getResponse()->setStatus('error');
        Response::getResponse()->setError('The end point does not exist', 'NOT FOUND');
        Response::getResponse()->setData(null);
    });
}
