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
        $nivel = $_SESSION['user']['nivel'];
        if($nivel == '1'){
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }

        $requests = $request->getParsedBody();
        $id = $requests['id'] ?? null;
        $cep = $requests['cep'] ?? null;
        $logradouro = $requests['logradouro'] ?? null;
        $cidade = $requests['usuario_id'] ?? null;

        if (!empty($id)) {
            $params['id'] = $id;
        }
        if (!empty($cep)) {
            $params['cep'] = $cep;
        }
        if (!empty($logradourome)) {
            $params['logradouro'] = $logradouro;
        }
        if (!empty($cidade)) {
            $params['cidade'] = $cidade;
        }

        if (!empty($params)) {
            $enderecos = EnderecoModel::list($params);
        } else {
            $enderecos = EnderecoModel::list();
        }

        return $response->withJson($enderecos, true, $enderecos->count() .($enderecos->count()>1?' endereços encontrados':' endereço encontrado'));
    }


    /**
     * Salva um enderecos 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $nivel = $_SESSION['user']['nivel'];
        if($nivel == '1'){
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }
        
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
