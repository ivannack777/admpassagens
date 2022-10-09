<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use App\Application\Controllers\BaseController;
use App\Application\Models\Usuarios;
use App\Application\Models\Favoritos as FavoritosModel;
use Monolog\Handler\RotatingFileHandler;
// use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Slim\Views\PhpRenderer;
use Valitron\Validator;
use App\Application\Models\ApiCall;

class Favoritos extends BaseController
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

        $item = $requests['item'] ?? null;
        $item_id = $requests['item_id'] ?? null;
        $usuario_id = $_SESSION['user']['id'];

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
            $pessoas = FavoritosModel::list($params);
        } else {
            $pessoas = FavoritosModel::list();
        }

        return $response->withJson($pessoas, true, $pessoas->count() . ($pessoas->count() > 1 ? ' pessoas encontradas' : ' pessoa encontrada'));
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
            $usuario_id = $_SESSION['user']['id'];

            $dados = [
                'item' => $item,
                'item_id' => $item_id,
                'usuario_id' => $usuario_id,
            ];

            $api = new ApiCall();
            $apiResult = $api->post('favoritos/salvar', $dados);

            // var_dump($apiResult->data);exit;
            
            return $response->withJson($apiResult->data, true, ($apiResult->data->resultado ? 'Favorito foi salvo' : 'Favorito foi excluído') );

            var_export($apiResult);exit;
            # definindo linguagem do validador
            Validator::lang('pt-br');
            $v = new Validator($dados);
            $v->rule('required', ['item', 'item_id', 'usuario_id']);
            $v->labels(
                array(
                    'item' => 'Item',
                    'item_id' => 'ID do item',
                    'usuario_id' => 'ID do usuário',
                )
            );

            if ($v->validate()) {

                $favoritos = FavoritosModel::list($dados);
                    
                if ($favoritos->count()) {
                    FavoritosModel::where($dados)->delete();
                    return $response->withJson(['resultado'=>0,'dados'=>$dados], true, 'Favorito excluído');
                } else {
                    FavoritosModel::create($dados);
                    $favoritosNew = FavoritosModel::list($dados);
                    return $response->withJson(['resultado'=>1,'dados'=>$favoritosNew], true, 'Favorito foi salvo');
                }
            } else {
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($Errors['errors'], false, $Errors['msg']);
            }
        }

        return $response->withJson([], false, 'Usuário não foi identificado');
    }
}
