<?php

declare(strict_types=1);

use App\Application\Controllers\Home;
use App\Application\Controllers\Empresas;
use App\Application\Controllers\Enderecos;
use App\Application\Controllers\ExcluirController;
use App\Application\Controllers\Localidades;
use App\Application\Controllers\Usuarios\Login;
use App\Application\Controllers\Usuarios\Pessoas;
use App\Application\Controllers\Usuarios\Usuarios;
use App\Application\Controllers\Veiculos;
use App\Application\Controllers\Viagens;
use App\Application\Controllers\Clientes;
use App\Application\Controllers\Pedidos;
use App\Application\Middleware\CheckTokenMiddleware;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use Slim\Views\PhpRenderer;

return function (App $app, Request $request) {
    //salvar log da rota
    $caminho = '';
    $uri = $request->getUri();
    $body = preg_replace('/\s+/', '', $request->getBody()->__toString() ?? null);
    $headers = $request->getHeaders();
    foreach ($headers as $name => $values) {
        $caminho .= $name.': '.implode(', ', $values).'; ';
    }
    $log = new Logger($body);
    $log->pushHandler(new RotatingFileHandler($_ENV['ACCESS_LOG'], 5, Logger::DEBUG));
    $log->info(
        $caminho,
        [
            'path' => $uri->getPath(),
            'query' => $uri->getQuery(),
            'fragment' => $uri->getFragment(),
        ]
    );

    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', [Home::class,'index']);
    
    $app->get('/usuarios/login/form', [Login::class, 'loginForm']);
    $app->post('/usuarios/login/entrar', [Login::class, 'login']);
    $app->get('/usuarios/login/sair', [Login::class, 'logout']);
    $app->get('/usuarios/registrar', [Login::class, 'registrarForm']);
    $app->get('/usuarios/resetsenha', [Login::class, 'resetsenhaForm']);

    $app->post('/usuarios/registrar/salvar', [Usuarios::class, 'save']);

    $app->group('/usuarios', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Usuarios::class, 'list']);
        $group->map(['GET', 'POST'], '/permissoes', [Usuarios::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Usuarios::class, 'save']);
        $group->map(['GET', 'POST'], '/pessoa', [Pessoas::class, 'list']);
        $group->post('/pessoa/salvar[/[{id}]]', [Pessoas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
        $group->post('/pessoa/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/veiculos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Veiculos::class, 'list']);
        $group->map(['GET', 'POST'], '/tipo', [Veiculos::class, 'tipo_list']);
        $group->post('/salvar[/[{id}]]', [Veiculos::class, 'save']);
        $group->post('/tipo/salvar[/[{id}]]', [Veiculos::class, 'tipo_save']);
        $group->post('/setFavorito/{id}', [Veiculos::class, 'setFavorite']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
        $group->post('/tipo/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/viagens', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Viagens::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Viagens::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/localidades', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Localidades::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Localidades::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/clientes', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Clientes::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Clientes::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/pedidos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Pedidos::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Pedidos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/enderecos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Enderecos::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Enderecos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/empresas', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Empresas::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Empresas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude'])->add(function (Request $request, RequestHandler $handler) {
            // passando dados extras para o controller
            $request = $request->withAttribute('tablename', 'empreendimento');
            // no controller, o dado é pego assim:
            // $dadoExtra = $request->getAttribute('tablename');

            return $handler->handle($request);
        });
    })->add(CheckTokenMiddleware::class);
};
