<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Dispositivo as DispositivoModel;
use App\Application\Models\Dispositivo_tipo as Dispositivo_tipoModel;
use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Dispositivos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



    /**
     * Localiza e retorna um dispositivos passando 'dispositivo' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        
        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $marca = $requests['marca'] ?? null;
        $modelo = $requests['modelo'] ?? null;
        
        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        $userSession = $_SESSION['user'];
        if ($userSession['nivel'] == '1') {
            $params['usuario_id'] = $userSession['id'];
        } else{
            if (!empty($usuario_id)) {
                $params['usuario_id'] = $usuario_id;
            }
        }
        if (!empty($nome)) {
            $params['nome'] = $nome;
        }
        if (!empty($marca)) {
            $params['marca'] = $marca;
        }

        if (!empty($modelo)) {
            $params['modelo'] = $modelo;
        }

        if (!empty($params)) {
            $dispositivos = DispositivoModel::list($params);
        } else {
            $dispositivos = DispositivoModel::list();
        }

        return $response->withJson($dispositivos, true, $dispositivos->count() . ' dispositivo(s) encontrado(s)');
    }


    /**
     * Localiza e retorna um dispositivos passando 'dispositivo' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function tipo_list(Request $request, Response $response)
    {

        $method = $request->getMethod();

        $requests = $request->getParsedBody();
        $nome = $requests['nome'] ?? null;
        $descricao = $requests['descricao'] ?? null;

        if (!empty($nome)) {
            $params['nome'] = $nome;
        }
        if (!empty($descricao)) {
            $params['descricao'] = $descricao;
        }

        if (!empty($params)) {
            $dispositivos = Dispositivo_tipoModel::list($params);
        } else {
            $dispositivos = Dispositivo_tipoModel::list();
        }

        return $response->withJson($dispositivos, true, $dispositivos->count() . ' tipo(s) de dispositivo(s) encontrado(s)');
    }

    /**
     * Salva um dispositivos 
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
        $empreendimento_id = $requests['empreendimento_id'] ?? null;
        $dispositivo_tipo_id = $requests['dispositivo_tipo_id'] ?? null;
        $nome =  $requests['nome'] ?? null;
        $marca = $requests['marca'] ?? null;
        $modelo = $requests['modelo'] ?? null;

        $dados = [
            'usuario_id' => $usuario_id,
            'empreendimento_id' => $empreendimento_id,
            'dispositivo_tipo_id' => $dispositivo_tipo_id,
            'nome' => $sanitize->string($nome)->doubles()->firstUp()->get(),
            'marca' => $sanitize->string($marca)->firstUp()->get(),
            'modelo' => $sanitize->string($modelo)->get(),
        ];


        if (!empty($id)) {
            $dispositivos = DispositivoModel::list(['id' => $id]);
            if ($dispositivos->count()) {
                //  var_dump($list);exit;

                DispositivoModel::where(['id' => $id])->update($dados);
                $dispositivos = DispositivoModel::list(['id' => $id]);
                return $response->withJson($dispositivos, true, 'Dispositivos foi salva');
            } else {
                return $response->withJson($requests, false, 'Dispositivo não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'nome','empreendimento_id','dispositivo_tipo_id']);

            if($v->validate()) {
                $dispositivoInsert = DispositivoModel::create($dados);
                $dispositivoNew = DispositivoModel::list(['id' => $dispositivoInsert->id]);
                return $response->withJson($dispositivoNew, true, 'Dispositivo foi adicionada');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
        
                return $response->withJson($dados, false,$Errors);
            }
        }
    }

    /**
     * Salva um tipo de dispositivos 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function tipo_save(Request $request, Response $response)
    {
        $nivel = $_SESSION['user']['nivel'];
        if($nivel == '1'){
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }
        
        $sanitize = new Sanitize();
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }

        $nome = $requests['nome'] ?? null;
        $descricao = $requests['descricao'] ?? null;

        $dados = [
            'nome' => $sanitize->name($nome)->get(),
            'descricao' => $sanitize->string($descricao)->firstUp(),
        ];
        // var_dump($dados);exit;
        if (!empty($id)) {
            $dispositivo_tipos = Dispositivo_tipoModel::list(['id' => $id]);
            if ($dispositivo_tipos->count()) {
                //  var_dump($list);exit;

                Dispositivo_tipoModel::where(['id' => $id])->update($dados);
                $dispositivo_tipos = Dispositivo_tipoModel::list(['id' => $id]);
                return $response->withJson($dispositivo_tipos, true, 'Tipo de dispositivo foi salvo');
            } else {
                return $response->withJson($requests, false, 'Tipo de dispositivo não foi localizado');
            }
        } else {
                        
            $v = new Validator($dados);
            $v->rule('required', ['nome']);
            
            if($v->validate()) {
                $dispositivo_tipoInsert = Dispositivo_tipoModel::create($dados);
                $dispositivo_tipoNew = Dispositivo_tipoModel::list(['id' => $dispositivo_tipoInsert->id]);
                return $response->withJson($dispositivo_tipoNew, true, 'Tipo de dispositivo foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
                return $response->withJson($dados, false,$Errors);
                
            }
        }
    }
}
