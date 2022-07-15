<?php

declare(strict_types=1);

namespace App\Application\Controllers\Dispositivos;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Dispositivo as DispositivoModel;
use App\Application\Models\Dispositivo_tipo as Dispositivo_tipoModel;

use App\Application\Actions\ActionPayload;

class Dispositivo
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

        $method = $request->getMethod();

        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id']??null;
        $nome = $requests['nome']??null;
        $marca = $requests['marca']??null;
        $modelo = $requests['modelo']??null;

        if (!empty($usuario_id))  {
            $params['usuario_id'] = $usuario_id;
        }
        if (!empty($nome)) {
            $params['nome'] = $nome;
        }
        if (!empty($marca)) {
            $params['marca'] = $marca;
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
        $nome = $requests['nome']??null;
        $descricao = $requests['descricao']??null;

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
    public function save(Request $request, Response $response)
    {

        $requests = $request->getParsedBody();
        if(empty($requests)){
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $usuario_id = $requests['usuario_id']??null;
        $dispositivo_tipo_id = $requests['dispositivo_tipo_id']??null;
        $nome = $requests['nome']??null;
        $marca = $requests['marca']??null;
        $modelo = $requests['modelo']??null;

        if (!empty($usuario_id) && !empty($nome) ) {
            $dados=[
                'usuario_id' => $usuario_id,
                'dispositivo_tipo_id' => $dispositivo_tipo_id,
                'nome' => $nome,
                'marca' => $marca,
                'modelo' => $modelo,
            ];
            $list = json_decode($this->list($request, $response)->getBody()->__toString());
            //  var_dump($list);exit;
            if(count($list->data)){
                
                $dispositivosResult = DispositivoModel::where(['id' => $list->data[0]->id])->update($dados);
                return $response->withJson($list->data[0], true, ' dispositivo foi salvo');
            } else {
                $dispositivosResult = DispositivoModel::insert($dados);
                return $response->withJson($dados, true, ' dispositivo foi adicionado');
            }
        } else{
            return $response->withJson($requests, false, ' usuario_id e nome são obrigatórios');
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

        $requests = $request->getParsedBody();
        if(empty($requests)){
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $usuario_id = $requests['usuario_id']??null;
        $nome = $requests['nome']??null;
        $descricao = $requests['descricao']??null;

        if (!empty($usuario_id) || !empty($nome) ) {
            $dados=[
                'nome' => $nome,
                'descricao' => $descricao,
            ];
            $list = json_decode($this->tipo_list($request, $response)->getBody()->__toString());
            //  var_dump($list);exit;
            if(count($list->data)){
                
                $dispositivosResult = Dispositivo_tipoModel::where(['id' => $list->data[0]->id])->update($dados);
                return $response->withJson($list->data[0], true, ' dispositivo foi salvo');
            } else {
                $dispositivosResult = Dispositivo_tipoModel::insert($dados);
                return $response->withJson($dados, true, ' dispositivo foi adicionado');
            }
        }
    }


}
