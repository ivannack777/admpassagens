<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Linhas as ViagenModel;
use App\Application\Models\Veiculos as VeiculosModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;


class Linhas extends BaseController
{
    // protected $container;
    // protected $ViagenModel;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        // $this->container = $container;
    }

    /**
     * Localiza e retorna um linhass passando 'linhas' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response, $args)
    {
        $dados = [];
        $requests = $request->getQueryParams();
        
        $apiResult = $this->api->post('veiculos/listar', $requests);
        $dados['veiculos'] = $apiResult;

        $apiResult = $this->api->post('linhas/listar', $requests);
        $dados['linhas'] = $apiResult;
        
        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'linhas_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'linhas.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }

    }

        /**
     * Localiza e retorna um linhass passando 'linhas' por json request.
     *
     * @return string json
     */
    public function listPoints(Request $request, Response $response, $args)
    {
        $dados = [];
        $requests = $request->getParsedBody();
        
        $apiResult = $this->api->post('linhas_pontos/listar', $requests);
        if(property_exists($apiResult, 'data')){
            return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
        }
        return $response->withJson([$apiResult], false, 'Erro na consulta', 500);
    }



    /**
     * Salva um linhass.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    { 
        // session_start();
        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $apiResult = $this->api->post('linhas/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

      
    }


}
