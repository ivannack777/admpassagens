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
        $this->container = $container;
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

        $endereco_id = $requests['endereco_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $cpf_cnpj = $requests['cpf_cnpj'] ?? null;
        $documento = $requests['documento'] ?? null;

        if (!empty($endereco_id)) {
            $params['endereco_id'] = $endereco_id;
        }
        if (!empty($nome)) {
            $params['nome'] = $nome;
        }
        if (!empty($cpf_cnpj)) {
            $params['cpf_cnpj'] = $cpf_cnpj;
        }
        if (!empty($documento)) {
            $params['documento'] = $documento;
        }

        if (!empty($params)) {
            $pessoas = PessoaModel::list($params);
        } else {
            $pessoas = PessoaModel::list();
        }

        return $response->withJson($pessoas, true, $pessoas->count() . ($pessoas->count()>1?' pessoas encontradas':' pessoa encontrada'));
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
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
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
                return $response->withJson($requests, false, 'Pessoa não foi localizado');
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
            },'cpf_cnpj')->message("Deve ter 11 ou 14 dígitos");

            if ($v->validate()) {
                $dados = array_filter($dados);
                if (!empty($dados['cpf_cnpj'])) {

                    $pessoas = PessoaModel::where('cpf_cnpj', $dados['cpf_cnpj']);
                    if ($pessoas->count()) {
                        return $response->withJson($dados, false, 'Já existe um usuário com este CPF/CNPJ');
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

        return $response->withJson(false, true, ' usuário foi salvo');
    }
}
