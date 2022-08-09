<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\DispositivoAmbiente as DispositivoAmbienteModel;

use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class DispositivosAmbiente extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



    /**
     * Localiza e retorna um dispositivoAmbientes passando 'dispositivoAmbiente' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        $requests = $request->getParsedBody();
        $id = $requests['id'] ?? null;
        $usuario_id = $requests['usuario_id'] ?? null;
        $ambiente_id = $requests['ambiente_id'] ?? null;
        $dispositivo_id = $requests['dispositivo_id'] ?? null;
        $nome = $requests['nome'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        $userSession = $_SESSION['user'];
        if ($userSession['nivel'] == '1') {
            $params['dispositivoAmbiente.usuario_id'] = $userSession['id'];
        } else{
            if (!empty($usuario_id)) {
                $params['dispositivoAmbiente.usuario_id'] = $usuario_id;
            }
        }
        if (!empty($id)) {
            $params['dispositivoAmbiente.id'] = $id;
        }
        if (!empty($ambiente_id)) {
            $params['dispositivoAmbiente.ambiente_id'] = $ambiente_id;
        }
        if (!empty($dispositivo_id)) {
            $params['dispositivoAmbiente.dispositivo_id'] = $dispositivo_id;
        }
        if (!empty($nome)) {
            $params['dispositivoAmbiente.nome'] = $nome;
        }

        if (!empty($params)) {
            $dispositivoAmbientes = DispositivoAmbienteModel::list($params);
        } else {
            $dispositivoAmbientes = DispositivoAmbienteModel::list();
        }



        return $response->withJson($dispositivoAmbientes, true, $dispositivoAmbientes->count() .($dispositivoAmbientes->count()>1 ? ' dispositivoAmbientes encontrados':' dispositivoAmbiente encontrado'));
    }


    /**
     * Salva um dispositivoAmbientes 
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
        $dispositivoAmbiente_tipo_id = $requests['dispositivoAmbiente_tipo_id'] ?? null;
        $empreendimento_id = $requests['empreendimento_id'] ?? null;
        $ambiente_id = $requests['ambiente_id'] ?? null;
        $nome =  $requests['nome'] ?? null;
        $marca = $requests['marca'] ?? null;
        $modelo = $requests['modelo'] ?? null;

        $dados = [
            'usuario_id' => $usuario_id,
            'dispositivoAmbiente_tipo_id' => $dispositivoAmbiente_tipo_id,
            'empreendimento_id' => $empreendimento_id,
            'ambiente_id' => $ambiente_id,
            'nome' => $sanitize->string($nome)->doubles()->firstUp()->get(),
            'marca' => $sanitize->string($marca)->firstUp()->get(),
            'modelo' => $sanitize->string($modelo)->get(),
        ];

        $dados = array_filter($dados);

        if (!empty($id)) {
            $dispositivoAmbientes = DispositivoAmbienteModel::list(['dispositivoAmbiente.id' => $id]);
            if ($dispositivoAmbientes->count()) {
                //  var_dump($list);exit;

                DispositivoAmbienteModel::where(['id' => $id])->update($dados);
                $dispositivoAmbientes = DispositivoAmbienteModel::list(['dispositivoAmbiente.id' => $id]);
                return $response->withJson($dispositivoAmbientes, true, 'DispositivoAmbientes foi salvo');
            } else {
                return $response->withJson($requests, false, 'DispositivoAmbiente não foi localizado');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'nome','empreendimento_id','dispositivoAmbiente_tipo_id']);

            if($v->validate()) {
                $dispositivoAmbienteInsert = DispositivoAmbienteModel::create($dados);
                $dispositivoAmbienteNew = DispositivoAmbienteModel::list(['dispositivoAmbiente.id' => $dispositivoAmbienteInsert->id]);
                return $response->withJson($dispositivoAmbienteNew, true, 'DispositivoAmbiente foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
        
                return $response->withJson($dados, false,$Errors);
            }
        }
    }



}
