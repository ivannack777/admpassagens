<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use App\Application\Models\ApiCall;

class ExcluirController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request.
     *
     * @return string $str
     */
    public function exclude(Request $request, Response $response, array $args)
    {

        $nivel = $_SESSION['user']['nivel']??0;
        if ($nivel < '3') {
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }
        
        $id = $args['id'] ?? null;

        $uriPath = $request->getUri()->getPath();
        // var_dump($uriPath);exit;
        $api = new ApiCall();
        $apiResult = $api->post($uriPath);

        return $response->withJson($apiResult->data, $apiResult->status, ($apiResult->msg) );
    }
}
