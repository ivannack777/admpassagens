<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Endereco as EnderecoModel;
use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Enderecos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request
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
            $enderecos = EnderecoModel::list($params);
        } else {
            $enderecos = EnderecoModel::list();
        }

        return $response->withJson($enderecos, true, $enderecos->count() . ' endereco(s) encontrado(s)');
    }


    /**
     * Salva um enderecos 
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

        $cep         = $requests['cep'] ?? null;
        $logradouro  = $requests['logradouro'] ?? null;
        $numero      = $requests['numero'] ?? null;
        $complemento = $requests['complemento'] ?? null;
        $uf          = $requests['uf'] ?? null;
        $cidade      = $requests['cidade'] ?? null;
        $pais        = $requests['pais'] ?? null;

        $dados = [
            'cep' => $sanitize->number($cep, 'clear')->get(),
            'logradouro' => $sanitize->string($logradouro)->get(),
            'numero' =>$sanitize->number($numero, 'clear')->get(),
            'complemento' => $sanitize->string($complemento)->get(),
            'uf' => $sanitize->string($uf)->toup()->get(),
            'cidade' => $sanitize->name($cidade)->get(),
            'pais' => $sanitize->name($pais)->get(),
        ];

        if (!empty($id)) {
            $enderecos = EnderecoModel::list(['id' => $id]);
            if ($enderecos->count()) {
                //  var_dump($list);exit;

                EnderecoModel::where(['id' => $id])->update($dados);
                $enderecos = EnderecoModel::list(['id' => $id]);
                return $response->withJson($enderecos, true, 'Enderecos foi salvo');
            } else {
                return $response->withJson($requests, false, 'Endereco não foi localizado');
            }
        } else {
            
            $v = new Validator($dados);
            $v->rule('required', ['cep', 'logradouro','cidade', 'uf']);

            if($v->validate()) {
                $enderecoInsert = EnderecoModel::create($dados);
                $enderecoNew = EnderecoModel::list(['id' => $enderecoInsert->id]);
                return $response->withJson($enderecoNew, true, 'Endereco foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
                return $response->withJson($dados, false,$Errors);
            }


            
        }
    }

}
