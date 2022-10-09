<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use App\Application\Controllers\BaseController;
use App\Application\Models\Usuarios;
use App\Application\Models\Comentarios as ComentariosModel;
use Monolog\Handler\RotatingFileHandler;
// use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Slim\Views\PhpRenderer;
use Valitron\Validator;
use App\Application\Models\ApiCall;

class Comentarios extends BaseController
{
    protected $container;
    protected $config;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
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

        $requests = $request->getParsedBody();

        $usuario_id = $_SESSION['user']['id']??0;
        if ($usuario_id < '1') {
            return $response->withJson([], true, 'Sessão encerrada', 403);
        }
        
        $item = $requests['item'] ?? null;
        $item_id = $requests['item_id'] ?? null;
 
        if (!empty($item)) {
            $params['item'] = $item;
        }
        if (!empty($item_id)) {
            $params['item_id'] = $item_id;
        }

        if (!empty($usuario_id)) {
            $params['usuario_id'] = $usuario_id;
        }

        if (!empty($params)) {
            $dados['comentarios'] = ComentariosModel::list($params);
        } else {
            $dados['comentarios'] = ComentariosModel::list();
        }

        $api = new ApiCall();
        $apiResult = $api->post('comentarios/listar', $params);
        // return $apiResult;
        $dados['comentarios'] = $apiResult;


        return $this->views->render($response, 'comentarios_list.php', $dados);
        // return $response->withJson($pessoas, true, $pessoas->count() . ($pessoas->count() > 1 ? ' pessoas encontradas' : ' pessoa encontrada'));
    }



    /**
     * Localiza, autentica e registra login
     *
     * @return string json
     */
    public function save(Request $request, Response $response): Response
    {
        // session_start();

        if ($_SESSION['user'] ?? false) {

            // $sanitize = new Sanitize();
            $requests = $request->getParsedBody();
            if (empty($requests)) {
                return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
            }

            $item = $requests['item'];
            $item_id = $requests['item_id'];
            $texto = $requests['texto'];
            $usuario_id = $_SESSION['user']['id'];

            $dados = [
                'item' => $item,
                'item_id' => $item_id,
                'texto' => $texto,
                'usuario_id' => $usuario_id,
            ];
            $api = new ApiCall();
            $apiResult = $api->post('comentarios/salvar', $dados);

            // var_dump($apiResult->data);exit;
            
            return $response->withJson($apiResult->data, true, ($apiResult->msg) );

            # definindo linguagem do validador
            Validator::lang('pt-br');
            $v = new Validator($dados);
            $v->rule('required', ['item', 'item_id', 'usuario_id']);
            $v->labels(
                array(
                    'item' => 'Item',
                    'item_id' => 'ID do item',
                    'texto' => 'Texto',
                    'usuario_id' => 'ID do usuário',
                )
            );

            if ($v->validate()) {

                if (!empty($id)) {
                    $comentarios = ComentariosModel::list(['id' => $id]);

                    if ($comentarios->count()) {
                        ComentariosModel::where($dados)->update($dados);
                        $comentariosNew = ComentariosModel::list(['id' => $id]);
                        return $response->withJson($comentariosNew, true, 'Comentário foi salvo');
                    } else {
                        return $response->withJson($dados, false, 'Comentário não foi localizado');
                    }
                } else {
                    $comentariosInsert = ComentariosModel::create($dados);
                    $comentariosNew = ComentariosModel::list(['id' => $comentariosInsert->id]);
                    return $response->withJson($comentariosNew, true, 'Comentário foi adicionado');
                }
            } else {
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($Errors['errors'], false, $Errors['msg']);
            }
        }

        return $response->withJson([], false, 'Usuário não foi identificado');
    }
}
