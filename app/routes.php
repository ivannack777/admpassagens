<?php

declare(strict_types=1);

use App\Application\Controllers\Home;
use App\Application\Controllers\Empresas;
use App\Application\Controllers\Enderecos;
use App\Application\Controllers\ExcluirController;
use App\Application\Controllers\Localidades;
use App\Application\Controllers\Locais;
use App\Application\Controllers\Usuarios\Login;
use App\Application\Controllers\Usuarios\Pessoas;
use App\Application\Controllers\Passageiros;
use App\Application\Controllers\Usuarios\Usuarios;
use App\Application\Controllers\Usuarios\Favoritos;
use App\Application\Controllers\Usuarios\Comentarios;
use App\Application\Controllers\Veiculos;
use App\Application\Controllers\Viagens;
use App\Application\Controllers\Linhas;
use App\Application\Controllers\Trechos;
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
// use Slim\Views\PhpRenderer;

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

    $app->get('/', [Home::class,'index'])->add(CheckTokenMiddleware::class);

    
    $app->get('/usuarios/login/form', [Login::class, 'loginForm']);
    $app->post('/usuarios/login/entrar', [Login::class, 'login']);
    $app->get('/usuarios/login/sair', [Login::class, 'logout']);
    $app->get('/usuarios/registrar', [Login::class, 'registrarForm']);
    $app->get('/usuarios/resetsenha', [Login::class, 'resetsenhaForm']);

    $app->post('/usuarios/registrar/salvar', [Usuarios::class, 'save']);

    $app->group('/usuarios', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Usuarios::class, 'list']);
        $group->map(['GET', 'POST'], '/permissoes', [Usuarios::class, 'list']);
        $group->map(['GET', 'POST'], '/pessoa', [Pessoas::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Usuarios::class, 'save']);
        $group->post('/pessoa/salvar[/[{id}]]', [Pessoas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
        $group->post('/pessoa/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/veiculos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Veiculos::class, 'list']);
        $group->map(['GET', 'POST'], '/tipo', [Veiculos::class, 'tipo_list']);
        $group->post('/salvar[/[{id}]]', [Veiculos::class, 'save']);
        $group->post('/tipo/salvar[/[{id}]]', [Veiculos::class, 'tipo_save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
        $group->post('/tipo/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/linhas', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Linhas::class, 'list']);
        $group->map(['GET', 'POST'], '/pontos[/]', [Linhas::class, 'listPoints']);
        // $group->map(['GET', 'POST'], '/trechos[/]', [Linhas::class, 'listTrechos']);
        $group->post('/salvar[/[{id}]]', [Linhas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/trechos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Trechos::class, 'home']);
        $group->map(['GET', 'POST'], '/listar', [Trechos::class, 'list']);
        // $group->map(['GET', 'POST'], '/pontos', [Trechos::class, 'listPoints']);
        $group->post('/salvar[/[{id}]]', [Trechos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);

    $app->group('/viagens', function (Group $group) {
        $group->map(['GET', 'POST'],'', [Viagens::class, 'home']);
        $group->map(['GET', 'POST'],'/listar', [Viagens::class, 'list']);
        $group->map(['GET', 'POST'],'/procurar', [Viagens::class, 'find']);
        $group->map(['GET', 'POST'],'/ocupacao', [Viagens::class, 'occupation']);
        
        $group->map(['GET', 'POST'], '/pontos[/]', [Viagens::class, 'listPoints']);
        $group->post('/salvar[/[{id}]]', [Viagens::class, 'save']);
        $group->post('/linha/salvar[/[{id}]]', [Viagens::class, 'saveRoute']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(new CheckTokenMiddleware());

    // $app->post('/viagens/salvar[/[{id}]]', [Viagens::class, 'save']);

    $app->group('/localidades', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Localidades::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Localidades::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(new CheckTokenMiddleware());
    
    $app->group('/locais', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Locais::class, 'home']);
        $group->map(['GET', 'POST'], '/listar', [Locais::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Locais::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(new CheckTokenMiddleware());

    $app->group('/pessoas', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Pessoas::class, 'home']);
        $group->map(['GET', 'POST'], '/listar', [Pessoas::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Pessoas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);
    // $app->post('/pessoas/salvar[/[{id}]]', [Pessoas::class, 'save']);

    $app->group('/pedidos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Pedidos::class, 'list']);
        $group->map(['GET', 'POST'], '/download', [Pedidos::class, 'download']);
        $group->map(['GET', 'POST'], '/status', [Pedidos::class, 'status']);
        $group->map(['GET', 'POST'], '/listStatus', [Pedidos::class, 'listStatus']);
        $group->post('/status/salvar[/[{id}]]', [Pedidos::class, 'statusSave']);
        $group->post('/salvar[/[{id}]]', [Pedidos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);
    // $app->post('/pedidos/salvar[/[{id}]]', [Pedidos::class, 'save']);

    $app->group('/passageiros', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Passageiros::class, 'home']);
        $group->map(['GET', 'POST'], '/listar', [Passageiros::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Passageiros::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);
    // $app->post('/pessoas/salvar[/[{id}]]', [Passageiros::class, 'save']);

    
    $app->group('/enderecos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Enderecos::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Enderecos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude']);
    })->add(CheckTokenMiddleware::class);
    // $app->post('/enderecos/salvar[/[{id}]]', [Enderecos::class, 'save']);

    $app->group('/empresas', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Empresas::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Empresas::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude'])->add(function (Request $request, RequestHandler $handler) {
            // passando dados extras para o controller
            $request = $request->withAttribute('tablename', 'empreendimento');
            // no controller, o dado ?? pego assim:
            // $dadoExtra = $request->getAttribute('tablename');
            
            return $handler->handle($request);
        });
    })->add(CheckTokenMiddleware::class);
    // $app->post('/empresas/salvar[/[{id}]]', [Empresas::class, 'save']);


    $app->group('/favoritos', function (Group $group) {
        $group->map(['GET', 'POST'], '', [Favoritos::class, 'list']);
        $group->post('/salvar[/]', [Favoritos::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude'])->add(function (Request $request, RequestHandler $handler) {
            // passando dados extras para o controller
            $request = $request->withAttribute('tablename', 'empreendimento');
            // no controller, o dado ?? pego assim:
            // $dadoExtra = $request->getAttribute('tablename');
            
            return $handler->handle($request);
        });
    })->add(CheckTokenMiddleware::class);
    // $app->post('/favoritos/salvar[/]', [Favoritos::class, 'save']);//->add(CheckTokenMiddleware::class);


    $app->group('/comentarios', function (Group $group) {
        $group->map(['GET', 'POST'], '/ver', [Comentarios::class, 'list']);
        $group->post('/salvar[/[{id}]]', [Comentarios::class, 'save']);
        $group->post('/excluir/{id}', [ExcluirController::class, 'exclude'])->add(function (Request $request, RequestHandler $handler) {
            // passando dados extras para o controller
            $request = $request->withAttribute('tablename', 'empreendimento');
            // no controller, o dado ?? pego assim:
            // $dadoExtra = $request->getAttribute('tablename');
            
            return $handler->handle($request);
        });
    })->add(CheckTokenMiddleware::class);
    // $app->post('/comentarios/salvar[/[{id}]]', [Comentarios::class, 'save']);//->add(CheckTokenMiddleware::class);

};
