<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\GrupoDispositivoAmbiente as GrupoDispositivoAmbienteModel;
use App\Application\Models\Dispositivo as DispositivoModel;

use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class GrupoDispositivosAmbiente extends BaseController
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
        $nome = $requests['nome'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        // $userSession = $_SESSION['user'];
        // if ($userSession['nivel'] == '1') {
        //     $params['grupo_dispositivo_ambiente.usuario_id'] = $userSession['id'];
        // } else{
        //     if (!empty($usuario_id)) {
        //         $params['grupo_dispositivo_ambiente.usuario_id'] = $usuario_id;
        //     }
        // }
        if (!empty($id)) {
            $params['grupo_dispositivo_ambiente.id'] = $id;
        }
        if (!empty($ambiente_id)) {
            $params['grupo_dispositivo_ambiente.ambiente_id'] = $ambiente_id;
        }
        if (!empty($nome)) {
            $params['grupo_dispositivo_ambiente.nome'] = $nome;
        }

        if (!empty($params)) {
            $dispositivoAmbientes = GrupoDispositivoAmbienteModel::list($params);
        } else {
            $dispositivoAmbientes = GrupoDispositivoAmbienteModel::list();
        }



        return $response->withJson($dispositivoAmbientes, true, $dispositivoAmbientes->count() .($dispositivoAmbientes->count()>1 ? ' grupo dispositivo/ambientes encontrados':' grupo de dispositivo/ambiente encontrado'));
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

    /**
     * Altera o estado de um dispositivo
     * criado metodo especifico para APP para ter segurança de que sempre terá id do usuario identificado pelo bearer token
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function setStateGroupApp(Request $request, Response $response, array $args)
    {
        $idGrupoDispositivoAmbiente = $args['idGrupoDispositivoAmbiente'] ?? null;
        
        $sanitize = new Sanitize();
        $requests = $request->getParsedBody();
        
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }

        $usuario_id = $_SESSION['user']['id'] ?? null;
        $estado = $requests['estado'] ?? null;


        $dados = [
            'estado' => $sanitize->integer($estado)->get(),
        ];

        //  var_dump($_SESSION);exit;

        if (!empty($idGrupoDispositivoAmbiente)) {
            $dispositivos = DispositivoModel::list(['dispositivo.grupo_dispositivo_ambiente_id' => $idGrupoDispositivoAmbiente, 'dispositivo.usuario_id'=>$usuario_id]);
            if ($dispositivos->count()) {

                //atualizar o estado do grupo_dispositivo_ambiente
                GrupoDispositivoAmbienteModel::where(['grupo_dispositivo_ambiente.id' => $idGrupoDispositivoAmbiente])->update($dados);

                 //atualizar o estado dos dispositivos  do grupo
                DispositivoModel::where(['dispositivo.grupo_dispositivo_ambiente_id' => $idGrupoDispositivoAmbiente])->update($dados);

                $grupoDispositivos = GrupoDispositivoAmbienteModel::list(['grupo_dispositivo_ambiente.id' => $idGrupoDispositivoAmbiente]);
                $dispositivos = DispositivoModel::list(['dispositivo.grupo_dispositivo_ambiente_id' => $idGrupoDispositivoAmbiente]);
                
                //adicionar dispositivos ao grupo para retorno
                $grupoDispositivos[0]->dispositivos = $dispositivos;

                return $response->withJson($grupoDispositivos, true, 'Estados dos dispositivos do ambiente foram alterados');
            } else {
                return $response->withJson(['dispositivo.id' => $idGrupoDispositivoAmbiente, 'dispositivo.usuario_id'=>$usuario_id], false, 'Grupo de dispositivos não foi localizado');
            }
        } 
        
        return $response->withJson($dados, false, 'ID do ambiente não foi informado');
    }


}
