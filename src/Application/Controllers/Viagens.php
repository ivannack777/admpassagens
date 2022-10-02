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


        // $descricao = $requests['descricao'] ?? null;
        // $origem = $requests['origem'] ?? null;
        // $destino = $requests['destino'] ?? null;
        // $data_saida = $requests['data_saida'] ?? null;
        // $data_chegada = $requests['data_chegada'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id


        // var_dump($this->views);
        // var_dump($request->getMethod());
        // var_dump($request->getUri()->getQuery());
        // var_dump($request->getQueryParams());
        // exit;
        if (!empty($descricao)) {
            $params['descricao'] = $descricao;
        }
        if (!empty($origem)) {
            $params['origem'] = $origem;
        }
        if (!empty($destino)) {
            $params['destino'] = $destino;
        }
        if (!empty($data_saida)) {
            $params['data_saida'] = $data_saida;
        }
        if (!empty($data_chegada)) {
            $params['data_chegada'] = $data_chegada;
        }

        $dados['veiculos'] = VeiculosModel::list();
        if (!empty($params)) {
            $dados['viagens'] = ViagenModel::lst($params);
        } else {
            $dados['viagens'] = ViagenModel::list();
        }
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
     * Salva um viagenss.
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
    }


}
