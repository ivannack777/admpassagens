<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use Slim\Http\Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use App\Application\Models\Usuario;
use Slim\Exception\HttpUnauthorizedException;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use \Slim\Routing\RouteContext;


class CheckTokenMiddleware implements Middleware
{

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {

        $routeContext = RouteContext::fromRequest($request);
        $uri =   $request->getUri();
        $headers = $request->getHeaders();

        $bearer = $request->getHeader('Authorization');

        if (isset($bearer[0]) && !empty($bearer[0]) && strpos($bearer[0], 'Bearer') !== false) {
            $bearer = explode(' ', $bearer[0]);
            if (isset($bearer[1]) && !empty($bearer[1])) {
                $usuarios = Usuario::getUserByToken($bearer[1]);
                // var_dump($bearer, $usuarios->count());
                if ($usuarios->count() === 1) {
                    session_start();
                    $_SESSION = [
                        'user' => [
                            'id'        => $usuarios[0]->id,
                            'usuario'   => $usuarios[0]->usuario,
                            'email'     => $usuarios[0]->email,
                            'celular'   => $usuarios[0]->celular,
                            'token'     => $usuarios[0]->token,
                            'nivel'     => $usuarios[0]->nivel,
                        ]
                    ];
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
                throw new HttpUnauthorizedException($request, 'Acesso não autorizado. Token inválido');
            }
        }
        //  return $response->withJson($request,false, 'Acesso não autorizado', 401);
        throw new HttpUnauthorizedException($request, 'Acesso não autorizado');
    }
}
