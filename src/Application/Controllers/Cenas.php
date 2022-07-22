<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Cena as CenaModel;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Cenas extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Localiza e retorna um cenass passando 'cenas' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id']??null;
        $configuracaoes = $requests['configuracaoes']??null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        $userSession = $_SESSION['user'];
        if ($userSession['nivel'] == '1') {
            $params['usuario_id'] = $userSession['id'];
        } else{
            if (!empty($usuario_id)) {
                $params['usuario_id'] = $usuario_id;
            }
        }
        if (!empty($configuracaoes)) {
            $params['configuracaoes'] = $configuracaoes;
        }
        
        if (!empty($params)) {
            $cenass = CenaModel::list($params);
        } else {
            $cenass = CenaModel::list();
        }

        return $response->withJson($cenass, true, $cenass->count() . ' cenas(s) encontrado(s)');

    
    }


    /**
     * Salva um cenass 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if(empty($requests)){
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        
        
        
        $usuario_id = $requests['usuario_id']??null;
        $nome = $requests['nome']??null;
        $configuracoes = $requests['configuracoes']??null;

        $dados=[
            'usuario_id' => $usuario_id,
            'nome' => $nome,
            'configuracoes' => json_encode($configuracoes),

        ];
        if (!empty($id)) {
            $cenas = CenaModel::list(['id' => $id]);
            if ($cenas->count()) {
                //  var_dump($list);exit;

                CenaModel::where(['id' => $id])->update($dados);
                $cenas = CenaModel::list(['id' => $id]);
                return $response->withJson($cenas, true, 'Cenas foi salva');
            } else {
                return $response->withJson($requests, false, 'Cena não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'nome']);

            if($v->validate()) {
                $cenaInsert = CenaModel::create($dados);
                $cenaNew = CenaModel::list(['id' => $cenaInsert->id]);
                return $response->withJson($cenaNew, true, 'Cena foi adicionada');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());
                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
