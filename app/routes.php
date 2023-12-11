<?php

declare(strict_types=1);

use App\Controllers\CoursesAPIController;
use App\Controllers\LoginController;
use App\Controllers\RegisterController;
use Slim\App;
use Slim\Views\PhpRenderer;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

    //demo code - two ways of linking urls to functionality, either via anon function or linking to a controller

    $app->get('/', function ($request, $response, $args) use ($container) {
        $renderer = $container->get(PhpRenderer::class);
        return $renderer->render($response, "index.php", $args);
    });

    $app->get('/courses', CoursesAPIController::class);
    $app->post('/login', LoginController::class);
    $app->post('/register', RegisterController::class);
};
