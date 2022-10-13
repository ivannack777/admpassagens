<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Viagens as ViagenModel;
use App\Application\Models\Veiculos as VeiculosModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;


class Viagens extends BaseController
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
     * Localiza e retorna um viagenss passando 'viagens' por json request.
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

        $apiResult = $this->api->post('viagens/listar', $requests);
        $dados['viagens'] = $apiResult;
        
        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'viagens_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'viagens.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }

        // return $response->withJson($viagens, true, $viagens->count().($viagens->count() > 1 ? ' viagens encontradas' : ' viagen encontrada'));
    }

        /**
     * Localiza e retorna um viagenss passando 'viagens' por json request.
     *
     * @return string json
     */
    public function listPoints(Request $request, Response $response, $args)
    {
        $dados = [];
        $requests = $request->getQueryParams();
        
        $apiResult = $this->api->post('viagens/pontos/listar', $requests);
        if(property_exists($apiResult, 'data')){
            return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
        }
        return $response->withJson([$apiResult], false, 'Erro na consulta', 500);
    }



    /**
     * Salva um viagenss.
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

        $apiResult = $this->api->post('viagens/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

        /*
        $usuario_id = $requests['usuario_id'] ?? null;
        $descricao = $requests['descricao'] ?? null;
        $origem_id = $requests['origem_id'] ?? null;
        $destino_id = $requests['destino_id'] ?? null;
        $data_saida = $this->dateFormat($requests['data_saida']) ?? null;
        $data_chegada = $this->dateFormat($requests['data_chegada']) ?? null;
        $valor = $requests['valor'] ?? null;
        $detalhes = $requests['detalhes'] ?? null;
        $assentos = $requests['assentos'] ?? null;
        $assentos_tipo = $requests['assentos_tipo'] ?? null;
        $veiculos_id = $requests['veiculos_id'] ?? null;

        $sanitize = new Sanitize();

        $dados = array_filter([
            'descricao' => $descricao,
            'origem_id' => $origem_id,
            'destino_id' => $destino_id,
            'data_saida' => $data_saida,
            'data_chegada' => $data_chegada,
            'valor' => str_replace(',', '.', $valor),
            'detalhes' => $detalhes,
            'assentos' => $assentos,
            'assentos_tipo' => $assentos_tipo,
            'veiculos_id' => $veiculos_id,
        ]);

        if (!empty($id)) {
            $viagens = ViagenModel::list(['viagens.id' => $id]);
            if ($viagens->count()) {
                ViagenModel::where(['viagens.id' => $id])->update($dados);
                $viagens = ViagenModel::list(['viagens.id' => $id]);

                return $response->withJson($viagens, true, 'Viagens foi salvo');
            } else {
                return $response->withJson($requests, false, 'Viagen não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['descricao', 'origem_id', 'destino_id', 'data_saida', 'data_chegada']);
            $v->labels(array(
                'descricao' => 'Descrição', 
                'origem' => 'Origem', 
                'origem_id' => 'Origem', 
                'destino' => 'Destino', 
                'destino_id' => 'Destino', 
                'data_saida' => 'Data saída', 
                'data_chegada' => 'Data chegada'
            ));
            if ($v->validate()) {
                $viagenInsert = ViagenModel::create($dados);
                $viagenNew = ViagenModel::list(['viagens.id' => $viagenInsert->id]);
                // var_dump($viagenNew);
       
                return $response->withJson($viagenNew, true, 'Viagem foi adicionada');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($Errors['errors'], false, $Errors['msg']);
            }
        }
        */
    }


    /**
     * Salva um viagenss.
     *
     * @return string json
     */
    public function saveRoute(Request $request, Response $response, array $args)
    { 
        // session_start();
        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }

        $apiResult = $this->api->post('viagens/linha/salvar/'.$id, $requests);
        return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);

        
    }

}
