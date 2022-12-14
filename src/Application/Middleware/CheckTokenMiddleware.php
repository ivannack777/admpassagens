<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Application\Models\Usuarios;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Http\Response;
use Slim\Routing\RouteContext;

class CheckTokenMiddleware implements Middleware
{
    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        session_start();
        $sessUser = $_SESSION['user'] ?? false;
        // $routeContext = RouteContext::fromRequest($request);
        // $headers = $request->getHeaders();
        
        // var_dump($_SESSION);exit;
        
        if(!$sessUser){
            $uri = $request->getUri();
            // echo "deu ruim";
            // $_SESSION["rememberuri"] = $uri->getPath();
            $response = $handler->handle($request);
            return $response->withHeader('Location', '/usuarios/login/form')->withStatus(302);
        }
        
        /*
        $bearer = $request->getHeader('Authorization');

        if (isset($bearer[0]) && !empty($bearer[0]) && strpos($bearer[0], 'Bearer') !== false) {
            $bearer = explode(' ', $bearer[0]);
            if (isset($bearer[1]) && !empty($bearer[1])) {
                $usuarios = Usuarios::getUserByToken($bearer[1]);
                // var_dump($bearer, $usuarios->count());
                if ($usuarios->count() === 1) {
                    // $body = preg_replace('/\s+/', '', $request->getBody() ?? null);
                    // $caminho = '';

                    // foreach ($headers as $name => $values) {
                    //     $caminho .= $name . ": " . implode(", ", $values) . "; ";
                    // }
                    // $log = new Logger(__CLASS__ . "::" . __FUNCTION__ . $body);
                    // $log->pushHandler(new RotatingFileHandler($_ENV['ACCESS_LOG'], 5, Logger::DEBUG));
                    // $log->info(
                    //     $caminho,
                    //     [
                    //         'path' => $uri->getPath(),
                    //         'query' => $uri->getQuery(),
                    //         'fragment' => $uri->getFragment()
                    //     ]
                    // );
                    return $handler->handle($request);
                }
            } else {
                throw new HttpUnauthorizedException($request, 'Acesso n??o autorizado. Token inv??lido');
            }
        }
        */
        // var_dump($uri);exit;
        // return $response->withHeader('Location', $uri->getPath())->withStatus(302);
        return $handler->handle($request);
        // throw new HttpUnauthorizedException($request, 'Acesso n??o autorizado');
    }
}
