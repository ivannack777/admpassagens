<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Ambiente as AmbienteModel;
use App\Application\Helpers\Sanitize;

use Valitron\Validator;
use App\Application\Controllers\BaseController;
use Exception;

class Ambientes extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



    /**
     * Localiza e retorna um ambientes passando 'ambientes' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {


        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id'] ?? null;
        $empreendimento_id = $requests['empreendimento_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        
        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        $userSession = $_SESSION['admpassagens']['user'];
        if ($userSession['nivel'] == '1') {
            $params['usuario_id'] = $userSession['id'];
        } else {
            if (!empty($usuario_id)) {
                $params['usuario_id'] = $usuario_id;
            }
        }
        if (!empty($empreendimento_id)) {
            $params['empreendimento_id'] = $empreendimento_id;
        }
        if (!empty($nome)) {
            $params['nome'] = $nome;
        }

        if (!empty($params)) {
            $ambientes = AmbienteModel::list($params);
        } else {
            $ambientes = AmbienteModel::list();
        }

        return $response->withJson($ambientes, true, $ambientes->count() . ($ambientes->count() > 1 ? ' ambientes encontrados' : ' ambiente encontrado'));
    }



    /**
     * Salva um ambientes 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {

        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $usuario_id        = $requests['usuario_id'] ?? null;
        $empreendimento_id = $requests['empreendimento_id'] ?? null;
        $nome              = $requests['nome'] ?? null;

        $sanitize = new Sanitize();

        $dados = [
            'usuario_id' => $usuario_id,
            'empreendimento_id' => $empreendimento_id,
            'nome' => $sanitize->name($nome, 'ucfirst')->get(),
        ];

        if (!empty($id)) {
            $ambientes = AmbienteModel::list(['id' => $id]);
            if ($ambientes->count()) {
                //  var_dump($list);exit;

                AmbienteModel::where(['id' => $id])->update($dados);
                $ambientes = AmbienteModel::list(['id' => $id]);
                return $response->withJson($ambientes, true, 'Ambiente foi salvo');
            } else {
                return $response->withJson($requests, false, 'Ambiente não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'empreendimento_id','nome']);

            if($v->validate()) {
                $ambienteInsert = AmbienteModel::create($dados);
                $ambienteNew = AmbienteModel::list(['id' => $ambienteInsert->id]);
                return $response->withJson($ambienteNew, true, 'Ambiente foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
                return $response->withJson($dados, false, $Errors);
            }
        }
    }


}
