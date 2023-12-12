<?php

declare(strict_types=1);

use App\Controllers\CoursesAPIController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use App\Controllers\UserController;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    // enable options requests
    $app->options('/{routes:.+}', function ($request, $response, $args) {
        return $response;
    });

    // enable CORS
    $app->add(function ($request, $handler) {
        $response = $handler->handle($request);
        return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    $app->get('/', function ($request, $response) {
        $html = '<h1>Invoice system API</h1>
                <p>To use this API please check the 
                    <a href="https://github.com/iO-Academy/invoicing-API#api-documentation" target="_blank">documentation</a>.
                </p>';
        $response->getBody()->write($html);
        return $response->withHeader('Content-type', 'text/html')->withStatus(200);
    });

    $app->get('/courses', CoursesAPIController::class);
    $app->post('/login', LoginController::class);
    $app->post('/register', RegisterController::class);
    $app->get('/users/{id}', UserController::class);
};
