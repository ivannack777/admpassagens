<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Pessoa as PessoaModel;
use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Pessoas extends BaseController
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
        $apiResult = $this->api->post('pessoas/listar', $requests);
        $dados['pessoas'] = $apiResult;

        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'pessoas.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'pessoas.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
        

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
        
        $apiResult = $this->api->post('pessoas/listar', $requests);
        // var_dump($apiResult);exit;
        if(property_exists($apiResult, 'data')){
            return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
        }
        return $response->withJson([$apiResult], false, 'Erro na consulta', 500);
    }



    /**
     * Localiza e retorna um pessoas passando 'pessoa' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $sanitize = new Sanitize();
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Par??metros incorretos.', 401);
        }

        $endereco_id = $requests['endereco_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $cpf_cnpj = $requests['cpf_cnpj'] ?? null;
        $natureza = $requests['natureza'] ?? null;
        $documento = $requests['documento'] ?? null;
        $orgao_emissor = $requests['orgao_emissor'] ?? null;
        
        $dados = [
            'endereco_id' => $endereco_id,
            'nome' => $nome,
            'cpf_cnpj' => $sanitize->number($cpf_cnpj,'clear')->get(),
            'documento' => $documento,
            'orgao_emissor' => $orgao_emissor,
        ];


        if (!empty($id)) {
            $pessoas = PessoaModel::list(['id' => $id]);
            if ($pessoas->count()) {
                PessoaModel::where(['id' => $id])->update($dados);
                $pessoas = PessoaModel::list(['id' => $id]);
                return $response->withJson($dados, true, 'Pessoas foi salvo');
            } else {
                return $response->withJson($requests, false, 'Pessoa n??o foi localizado');
            }
        } else {

            $v = new Validator($dados);

            $rules = [
                'required' => [
                    ['nome'],
                ],
                'lengthMin' => [
                    ['nome', 3]
                ]
            ];
            $v->rules($rules);
            $v->rule(function($field, $value) { //definindo regra personaliza
                if(strlen($value)===11) return true; // CPF
                if(strlen($value)===14) return true; //CNPJ
                return false;
            },'cpf_cnpj')->message("Deve ter 11 ou 14 d??gitos");

            if ($v->validate()) {
                $dados = array_filter($dados);
                if (!empty($dados['cpf_cnpj'])) {

                    $pessoas = PessoaModel::where('cpf_cnpj', $dados['cpf_cnpj']);
                    if ($pessoas->count()) {
                        return $response->withJson($dados, false, 'J?? existe um usu??rio com este CPF/CNPJ');
                    }
                }

                $pessoaInsert = PessoaModel::create($dados);
                $pessoaNew = PessoaModel::list(['id' => $pessoaInsert->id]);
                return $response->withJson($pessoaNew, true, 'Pessoa foi adicionado');
            } else {
                 // Errors
                 $Errors = $this->valitorMessages($v->errors());
                 return $response->withJson($dados, false,$Errors);
            }
        }

        return $response->withJson(false, true, ' usu??rio foi salvo');
    }
}
