<?php

declare(strict_types=1);

use App\Controllers\LoginController;
use App\Controllers\NoodleController;
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

    $app->post('/login', LoginController::class);
    $app->post('/register', RegisterController::class);
    $app->get('/users/{id}', UserController::class);
    $app->get('/noodles/{id}', NoodleController::class);
};
