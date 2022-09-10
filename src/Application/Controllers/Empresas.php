<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Empresas as EmpresasModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Empresas extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um empresas passando 'empresa' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        // $nivel = $_SESSION['user']['nivel'];
        // if ($nivel == '1') {
        //     return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        // }

        $requests = $request->getParsedBody();
        $usuarios_id = $requests['usuarios_id'] ?? null;
        $enderecos_id = $requests['enderecos_id'] ?? null;
        $nome = $requests['nome'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuarios_id
        // $userSession = $_SESSION['user'];
        // if ($userSession['nivel'] == '1') {
        //     $params['usuarios_id'] = $userSession['id'];
        // } else {
        //     if (!empty($usuarios_id)) {
        //         $params['usuarios_id'] = $usuarios_id;
        //     }
        // }

        if (!empty($enderecos_id)) {
            $params['enderecos_id'] = $enderecos_id;
        }
        if (!empty($nome)) {
            $params['nome'] = $nome;
        }

        if (!empty($params)) {
            $dados['empresas'] = EmpresasModel::list($params);
        } else {
            $dados['empresas'] = EmpresasModel::list();
        }

        
        if ($args['modo']??false == 'lista') {
            sleep(1);
            return $this->views->render($response, 'veiculos_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'empresas.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
    }

    /**
     * Salva um empresas.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        // $nivel = $_SESSION['user']['nivel'];
        // if ($nivel == '1') {
        //     return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        // }

        $id = $args['id'] ?? null;
        $sanitize = new Sanitize();
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }

        $usuarios_id = $requests['usuarios_id'] ?? null;
        $enderecos_id = $requests['enderecos_id'] ?? null;
        $nome = $requests['nome'] ?? null;

        $dados = [
            // 'usuarios_id' => $usuarios_id,
            // 'enderecos_id' => $enderecos_id,
            'nome' => $sanitize->string($nome)->doubles()->firstUp()->get(),
        ];

        if (!empty($id)) {
            $empresas = EmpresasModel::list(['id' => $id]);
            if ($empresas->count()) {
                //  var_dump($list);exit;

                EmpresasModel::where(['id' => $id])->update($dados);
                $empresas = EmpresasModel::list(['id' => $id]);

                return $response->withJson($empresas, true, 'Empresas foi salva');
            } else {
                return $response->withJson($requests, false, 'Empresas não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuarios_id', 'enderecos_id', 'nome']);

            if ($v->validate()) {
                $empresaInsert = EmpresasModel::create($dados);
                $empresaNew = EmpresasModel::list(['id' => $empresaInsert->id]);

                return $response->withJson($empresaNew, true, 'Empresas foi adicionada');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
