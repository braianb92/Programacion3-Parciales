<?php

use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsersController;
use App\Controllers\MateriasController;
use App\Controllers\InscriptosController;
use App\Middleware\ContentTypeMiddleware;
use App\Middleware\JwtMiddleware;


return function ($app) {

    //PUNTO 1
    $app->post('/usuario', UsersController::class . ':add');

    //PUNTO2
    $app->post('/login', UsersController::class . ':login');

    $app->group('/materias', function (RouteCollectorProxy $group) {
        //PUNTO 3
        //SOLO ADMIN
        $group->post('[/]', MateriasController::class . ':addMateria')->add(JwtMiddleware::class);

        //PUNTO 4
        $group->get('/{id}[/]', MateriasController::class . ':getMateria')->add(JwtMiddleware::class);

        // //PUNTO 5
        // $group->put('/{id}/{profesor}[/]', MateriasController::class . ':')->add(JwtMiddleware::class);

        //PUNTO 6
        //SOLO ALUMNO
        $group->put('/{id}', InscriptosController::class . ':inscribir')->add(JwtMiddleware::class);

        //PUNTO 7
        $group->get('[/]', MateriasController::class . ':getAll')->add(JwtMiddleware::class);
        
    });
};