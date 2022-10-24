<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use App\Application\Controllers\BaseController;
use App\Application\Models\Usuarios;
use App\Application\Models\Favoritos as FavoritosModel;
use Monolog\Handler\RotatingFileHandler;
// use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Slim\Views\PhpRenderer;
use Valitron\Validator;
use App\Application\Models\ApiCall;

class Favoritos extends BaseController
{
    protected $container;
    protected $config;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }


    /**
     * Localiza e retorna um pessoas passando 'pessoa' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        $requests = $this->getRequests($request);

        $item = $requests['item'] ?? null;
        $item_id = $requests['item_id'] ?? null;
        $usuario_id = $_SESSION['user']['id'];

        if (!empty($item)) {
            $params['item'] = $item;
        }
        if (!empty($item_id)) {
            $params['item_id'] = $item_id;
        }
        if (!empty($usuario_id)) {
            $params['usuario_id'] = $usuario_id;
        }

        if (!empty($params)) {
            $pessoas = FavoritosModel::list($params);
        } else {
            $pessoas = FavoritosModel::list();
        }

        return $response->withJson($pessoas, true, $pessoas->count() . ($pessoas->count() > 1 ? ' pessoas encontradas' : ' pessoa encontrada'));
    }



    /**
     * Localiza, autentica e registra login
     *
     * @return string json
     */
    public function save(Request $request, Response $response): Response
    {
        // session_start();

        if ($_SESSION['user'] ?? false) {
            
            // $sanitize = new Sanitize();
            $requests = $this->getRequests($request);
            if (empty($requests)) {
                return  $response->withJson([], false, 'Parâmetros incorretos.', 401);
            }


            $api = new ApiCall();
            $apiResult = $api->post('favoritos/salvar', $requests);

            // var_dump($apiResult->data);exit;
            
            return $response->withJson($apiResult->data, true, ($apiResult->data->resultado ? 'Favorito foi salvo' : 'Favorito foi excluído') );

        }

        return $response->withJson([], false, 'Usuário não foi identificado');
    }
}
