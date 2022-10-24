<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Enderecos as EnderecosModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Enderecos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $nivel = $_SESSION['user']['nivel'];
        if ($nivel == '1') {
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }

        $requests = $this->getRequests($request);
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
            $enderecos = EnderecosModel::list($params);
        } else {
            $enderecos = EnderecosModel::list();
        }

        return $response->withJson($enderecos, true, $enderecos->count().($enderecos->count() > 1 ? ' endereços encontrados' : ' endereço encontrado'));
    }

    /**
     * Salva um enderecos.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $nivel = $_SESSION['user']['nivel'];
        if ($nivel == '1') {
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }

        $id = $args['id'] ?? null;
        $sanitize = new Sanitize();
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }

        $cep = $requests['cep'] ?? null;
        $logradouro = $requests['logradouro'] ?? null;
        $numero = $requests['numero'] ?? null;
        $complemento = $requests['complemento'] ?? null;
        $uf = $requests['uf'] ?? null;
        $cidade = $requests['cidade'] ?? null;
        $pais = $requests['pais'] ?? null;

        $dados = [
            'cep' => $sanitize->number($cep, 'clear')->get(),
            'logradouro' => $sanitize->string($logradouro)->get(),
            'numero' => $sanitize->number($numero, 'clear')->get(),
            'complemento' => $sanitize->string($complemento)->get(),
            'uf' => $sanitize->string($uf)->toup()->get(),
            'cidade' => $sanitize->name($cidade)->get(),
            'pais' => $sanitize->name($pais)->get(),
        ];

        if (!empty($id)) {
            $enderecos = EnderecosModel::list(['id' => $id]);
            if ($enderecos->count()) {
                //  var_dump($list);exit;

                EnderecosModel::where(['id' => $id])->update($dados);
                $enderecos = EnderecosModel::list(['id' => $id]);

                return $response->withJson($enderecos, true, 'Enderecoss foi salvo');
            } else {
                return $response->withJson($requests, false, 'Enderecos não foi localizado');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['cep', 'logradouro', 'cidade', 'uf']);

            if ($v->validate()) {
                $enderecoInsert = EnderecosModel::create($dados);
                $enderecoNew = EnderecosModel::list(['id' => $enderecoInsert->id]);

                return $response->withJson($enderecoNew, true, 'Enderecos foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
