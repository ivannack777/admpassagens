<?php

declare(strict_types=1);

use App\Application\Controllers\Ambientes;
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
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;


return function (App $app, Request $request) {

    //salvar log da rota
    $caminho = '';
    $uri =   $request->getUri();
    $body = preg_replace('/\s+/', '', $request->getBody()->__toString() ?? null);
    $headers = $request->getHeaders();
    foreach ($headers as $name => $values) {
        $caminho .= $name . ": " . implode(", ", $values) . "; ";
    }
    $log = new Logger( $body );
    $log->pushHandler(new RotatingFileHandler($_ENV['ACCESS_LOG'], 5, Logger::DEBUG));
    $log->info(
        $caminho,
        [
            'path' => $uri->getPath(),
            'query' => $uri->getQuery(),
            'fragment' => $uri->getFragment()
        ]
    );
    


    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });


    $app->get('/', function (Request $request, Response $response) {
        // $response->getBody()->write('Olá, bem bindo a API Automação!');
        
        $readme = file_get_contents(__DIR__.'/../doc/usage.md');
        $Parsedown = new Parsedown();
        $md = $Parsedown->text($readme); # prints: <p>Hello <em>Parsedown</em>!</p>

        $response->getBody()->write($md);
        return $response;
    });

    $app->post('/usuarios/login/auth', [Login::class , 'auth']);

    $app->group('/usuarios', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Usuarios::class, 'list']);
        $group->post('/salvar[/{id}]', [Usuarios::class, 'save']);
        $group->map(['GET','POST'], '/pessoa/listar', [Pessoas::class, 'list']);
        $group->post('/pessoa/salvar[/{id}]', [Pessoas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
        $group->post('/pessoa/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);


    $app->group('/ambientes', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Ambientes::class, 'list']);
        $group->post('/salvar[/{id}]', [Ambientes::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class,$app);


    $app->group('/dispositivos', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Dispositivos::class, 'list']);
        $group->map(['GET','POST'], '/tipo/listar', [Dispositivos::class, 'tipo_list']);
        $group->post('/salvar[/{id}]', [Dispositivos::class, 'save']);
        $group->post('/tipo/salvar[/{id}]', [Dispositivos::class, 'tipo_save']);
        $group->post('/setEstadoAPP/{id}', [Dispositivos::class, 'setStateApp']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
        $group->post('/tipo/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/cenas', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Cenas::class, 'list']);
        $group->post('/salvar[/{id}]', [Cenas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class,$app);

    $app->group('/rotinas', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Rotinas::class, 'list']);
        $group->post('/salvar[/{id}]', [Rotinas::class, 'save']);
        $group->post('/executar', [Rotinas::class, 'execute']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/enderecos', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Enderecos::class, 'list']);
        $group->post('/salvar[/{id}]', [Enderecos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/empreendimentos', function (Group $group) {
        $group->map(['GET','POST'], '/listar', [Empreendimentos::class, 'list']);
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
