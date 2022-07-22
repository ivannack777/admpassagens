<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Empreendimento as EmpreendimentoModel;
use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Empreendimentos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um empreendimentos passando 'empreendimento' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id'] ?? null;
        $endereco_id = $requests['endereco_id'] ?? null;
        $nome = $requests['nome'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        $userSession = $_SESSION['user'];
        if ($userSession['nivel'] == '1') {
            $params['usuario_id'] = $userSession['id'];
        } else{
            if (!empty($usuario_id)) {
                $params['usuario_id'] = $usuario_id;
            }
        }

        if (!empty($endereco_id)) {
            $params['endereco_id'] = $endereco_id;
        }
        if (!empty($nome)) {
            $params['nome'] = $nome;
        }

        if (!empty($params)) {
            $empreendimentos = EmpreendimentoModel::list($params);
        } else {
            $empreendimentos = EmpreendimentoModel::list();
        }

        return $response->withJson($empreendimentos, true, $empreendimentos->count() . ' empreendimento(s) encontrado(s)');
    }


    /**
     * Salva um empreendimentos 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $sanitize = new Sanitize();
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }

        $usuario_id = $requests['usuario_id'] ?? null;
        $endereco_id = $requests['endereco_id'] ?? null;
        $nome =  $requests['nome'] ?? null;

        $dados = [
            'usuario_id' => $usuario_id,
            'endereco_id' => $endereco_id,
            'nome' => $sanitize->string($nome)->doubles()->firstUp()->get(),
        ];

        

        if (!empty($id)) {
            $empreendimentos = EmpreendimentoModel::list(['id' => $id]);
            if ($empreendimentos->count()) {
                //  var_dump($list);exit;

                EmpreendimentoModel::where(['id' => $id])->update($dados);
                $empreendimentos = EmpreendimentoModel::list(['id' => $id]);
                return $response->withJson($empreendimentos, true, 'Empreendimentos foi salvo');
            } else {
                return $response->withJson($requests, false, 'Empreendimento não foi localizado');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'endereco_id','nome']);

            if($v->validate()) {
                $empreendimentoInsert = EmpreendimentoModel::create($dados);
                $empreendimentoNew = EmpreendimentoModel::list(['id' => $empreendimentoInsert->id]);
                return $response->withJson($empreendimentoNew, true, 'Empreendimento foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
