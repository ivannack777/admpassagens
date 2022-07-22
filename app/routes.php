<?php

declare(strict_types=1);

// use App\Application\Actions\User\ListUsersAction;
use App\Application\Middleware\CheckTokenMiddleware;
use App\Application\Controllers\Usuarios\Login;
use App\Application\Controllers\Usuarios\Usuarios;
use App\Application\Controllers\Usuarios\Pessoas;
use App\Application\Controllers\Dispositivos;
use App\Application\Controllers\Cenas;
use App\Application\Controllers\Rotinas;
use App\Application\Controllers\Enderecos;
use App\Application\Controllers\Empreendimentos;
use App\Application\Controllers\ExcluirController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
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

    $app->post('/usuarios/login/auth', [Login::class , 'auth']);

    $app->group('/usuarios', function (Group $group) {
        $group->get('/listar', [Usuarios::class, 'list']);
        $group->post('/salvar[/{id}]', [Usuarios::class, 'save']);
        $group->get('/pessoa/listar', [Pessoas::class, 'list']);
        $group->post('/pessoa/salvar[/{id}]', [Pessoas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/dispositivos', function (Group $group) {
        $group->get('/listar', [Dispositivos::class, 'list']);
        $group->get('/tipo/listar', [Dispositivos::class, 'tipo_list']);
        $group->post('/salvar[/{id}]', [Dispositivos::class, 'save']);
        $group->post('/tipo/salvar[/{id}]', [Dispositivos::class, 'tipo_save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/cenas', function (Group $group) {
        $group->get('/listar', [Cenas::class, 'list']);
        $group->post('/salvar[/{id}]', [Cenas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class,$app);

    $app->group('/rotinas', function (Group $group) {
        $group->get('/listar', [Rotinas::class, 'list']);
        $group->post('/salvar[/{id}]', [Rotinas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/enderecos', function (Group $group) {
        $group->get('/listar', [Enderecos::class, 'list']);
        $group->post('/salvar[/{id}]', [Enderecos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/empreendimentos', function (Group $group) {
        $group->get('/listar', [Empreendimentos::class, 'list']);
        $group->post('/salvar[/{id}]', [Empreendimentos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude'])->add(function (Request $request, RequestHandler $handler) {
            // passando dados extras para o controller
            $request = $request->withAttribute('tablename', 'empreendimento');
            // no controller, o dado é pego assim:
            // $dadoExtra = $request->getAttribute('tablename');
            
            return $handler->handle($request);
        });
    })->add(CheckTokenMiddleware::class);



};
