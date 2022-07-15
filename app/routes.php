<?php

declare(strict_types=1);

// use App\Application\Actions\User\ListUsersAction;
use App\Application\Middleware\CheckTokenMiddleware;
use App\Application\Controllers\Usuarios\Login;
use App\Application\Controllers\Usuarios\Usuario;
use App\Application\Controllers\Dispositivos\Dispositivo;
use App\Application\Usuarios\Token;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;



return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });


    $app->get('/', function (Request $request, Response $response) {
        
        $response->getBody()->write('Olá, bem bindo a API Automação!');
        return $response;
    });

    $app->post('/users/login/auth', [Login::class , 'auth']);

    $app->group('/users', function (Group $group) {
        $group->get('/list', [Usuario::class,'list']);
        $group->post('/save', [Usuario::class, 'save']);
    })->add(CheckTokenMiddleware::class,$app);

    $app->group('/dispositivos', function (Group $group) {
        $group->get('/list', [Dispositivo::class,'list']);
        $group->get('/tipo/list', [Dispositivo::class,'tipo_list']);
        $group->post('/save', [Dispositivo::class, 'save']);
        $group->post('/tipo/save', [Dispositivo::class, 'tipo_save']);
    })->add(CheckTokenMiddleware::class,$app);

};
