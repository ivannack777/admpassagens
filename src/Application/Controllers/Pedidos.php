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
        $pedidosArr = [];
        $requests = $this->getRequests($request);//postt

        $apiResult = $this->api->post('pedidos/listar', $requests);
        $pedidos = $apiResult;
        // var_dump($pedidos);exit;

        $apiResult = $this->api->post('clientes/listar', $requests);
        $dados['clientes'] = $apiResult;

        $apiResult = $this->api->post('viagens/listar');
        $dados['viagens'] = $apiResult;

        # agrupar pedidos por viagem
        foreach($pedidos->data as $pedido){
            $pedidosArr[$pedido->viagens_id][$pedido->id] = $pedido;
        }
        $dados['pedidosViagens'] = $pedidosArr;


        //usando $this->view setado em BaseController
        if ( ($requests['modo']??false) == 'lista') {
            return $response->withJson($pedidos->data, $pedidos->status, $pedidos->count . ($pedidos->count > 1 ? ' pedidos encontrados' : ' pedido encontrado'));
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
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $apiResult = $this->api->post('pedidos/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

    }
}
