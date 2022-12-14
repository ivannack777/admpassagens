<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Clientes as ClientesModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Clientes extends BaseController
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
        $apiResult = $this->api->post('clientes/listar', $requests);
        $dados['clientes'] = $apiResult;

        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'clientes.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'clientes.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
        

    }
    /**
     * Localiza e retorna um clientes passando 'clientes' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $requests = $this->getRequests($request);
        $apiResult = $this->api->post('clientes/listar', $requests);

        if($apiResult){
            return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
        }
        return $response->withJson([], false, 'Erro na consulta', 500);

    }

    /**
     * Salva um clientes.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Par??metros incorretos.', 401);
        }
        $nome = $requests['nome'] ?? null;
        $cpf = $requests['cpf'] ?? null;
        $celular = $requests['celular'] ?? null;
        $email = $requests['email'] ?? null;

        $sanitize = new Sanitize();

        $dados = [
            'nome' => $sanitize->name($nome, 'ucfirst')->get(),
            'cpf' => $sanitize->number($cpf, 'clear')->get(),
            'celular' => $sanitize->number($celular, 'clear')->get(),
            'email' => $sanitize->email($email)->get(),
        ];

        if (!empty($id)) {
            $clientes = ClientesModel::list(['id' => $id]);
            if ($clientes->count()) {
                //  var_dump($list);exit;

                ClientesModel::where(['id' => $id])->update($dados);
                $clientes = ClientesModel::list(['id' => $id]);

                return $response->withJson($clientes, true, 'Clientes foi salvo');
            } else {
                return $response->withJson($requests, false, 'Clientes n??o foi localizada');
            }
        } else {
            $clientes = ClientesModel::list(['cpf' => $dados['cpf']]);
            if($clientes->count()){
                return $response->withJson($dados, false, 'J?? existe um cadastro com esse CPF');
            }
            $v = new Validator($dados);
            $v->rule('required', ['nome', 'cpf']);

            if ($v->validate()) {
                $clientesInsert = ClientesModel::create($dados);
                $clientesNew = ClientesModel::list(['id' => $clientesInsert->id]);

                return $response->withJson($clientesNew, true, 'Cliente foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
