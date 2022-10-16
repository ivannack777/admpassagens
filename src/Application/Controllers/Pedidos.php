<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Pedidos as PedidosModel;
use App\Application\Models\Viagens as ViagensModel;
use App\Application\Models\Clientes as ClientesModel;
use App\Application\Models\Localidades as LocalidadesModel;
use App\Application\Models\LocalidadesLog as LocalidadesLogModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Pedidos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um pedidos passando 'pedidos' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $requests = $request->getParsedBody();
        $apiResult = $this->api->post('pedidos/listar', $requests);
        $dados['pedidos'] = $apiResult;

        $apiResult = $this->api->post('clientes/listar', $requests);
        $dados['clientes'] = $apiResult;

        $apiResult = $this->api->post('viagens/listar', $requests);
        $dados['viagens'] = $apiResult;

        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'viagens_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'pedidos.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
    }

    /**
     * Salva um pedidos.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $apiResult = $this->api->post('pedidos/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

    }
}
