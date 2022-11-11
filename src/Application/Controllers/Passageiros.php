<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;

class Passageiros extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um clientes passando 'clientes' por json request.
     *
     * @return string json
     */
    public function home(Request $request, Response $response)
    {
        $requests = $this->getRequests($request);
        $apiResult = $this->api->post('passageiros/listar', $requests);
        $dados['passageiros'] = $apiResult;

        $this->views->render($response, 'header.php', $dados);
        $this->views->render($response, 'left.php', $dados);
        $this->views->render($response, 'right_top.php', $dados);
        $this->views->render($response, 'passageiros.php', $dados);
        return $this->views->render($response, 'footer.php', $dados);
    }

    /**
     * Localiza e retorna um passageiros passando 'passageiro' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        $requests = $this->getRequests($request);
        
        $apiResult = $this->api->post('passageiros/listar', $requests);
        // var_dump($apiResult);exit;
        if(property_exists($apiResult, 'data')){
            return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
        }
        return $response->withJson([$apiResult], false, 'Erro na consulta', 500);
    }



    /**
     * Localiza e retorna um passageiros passando 'passageiro' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $apiResult = $this->api->post('passageiros/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
    }
}
