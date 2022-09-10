<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Veiculos as VeiculosModel;
use App\Application\Models\Veiculos_tipo as Veiculos_tipoModel;
use App\Application\Models\Empresas as EmpresasModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Veiculos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um veiculoss passando 'veiculos' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response, $args)
    {
        $requests = $request->getParsedBody();
        $id = $requests['id'] ?? null;
        $usuarios_id = $requests['usuarios_id'] ?? null;
        $veiculos_tipo_id = $requests['veiculos_tipo_id'] ?? null;
        $empresas_id = $requests['empresas_id'] ?? null;
        $marca = $requests['marca'] ?? null;
        $modelo = $requests['modelo'] ?? null;
        $ano = $requests['ano'] ?? null;
        $codigo = $requests['codigo'] ?? null;
        $placa = $requests['placa'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuarios_id
        // $userSession = $_SESSION['user'];

        if (!empty($id)) {
            $params['veiculos.id'] = $id;
        }
        if (!empty($veiculos_tipo_id)) {
            $params['veiculos.veiculos_tipo_id'] = $veiculos_tipo_id;
        }
        if (!empty($empresas_id)) {
            $params['veiculos.empresas_id'] = $empresas_id;
        }
        if (!empty($marca)) {
            $params['veiculos.marca'] = $marca;
        }
        if (!empty($modelo)) {
            $params['veiculos.modelo'] = $modelo;
        }
        if (!empty($ano)) {
            $params['veiculos.ano'] = $ano;
        }
        if (!empty($codigo)) {
            $params['veiculos.codigo'] = $codigo;
        }
        if (!empty($placa)) {
            $params['veiculos.placa'] = $placa;
        }

        if (!empty($params)) {
            $dados['veiculos'] = VeiculosModel::list($params);
        } else {
            $dados['veiculos'] = VeiculosModel::list();
        }
        $dados['empresas'] = EmpresasModel::list();
        $dados['veiculos_tipo'] = Veiculos_tipoModel::list();
        
        if ($args['modo']??false == 'lista') {
            sleep(1);
            return $this->views->render($response, 'veiculos_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'veiculos.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }

    }

    /**
     * Localiza e retorna um veiculoss passando 'veiculos' por json request.
     *
     * @return string json
     */
    public function tipo_list(Request $request, Response $response)
    {
        $requests = $request->getParsedBody();
        $id = $requests['id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $descricao = $requests['descricao'] ?? null;

        if (!empty($id)) {
            $params['id'] = $id;
        }

        if (!empty($nome)) {
            $params['nome'] = $nome;
        }
        if (!empty($descricao)) {
            $params['descricao'] = $descricao;
        }

        if (!empty($params)) {
            $dados['veiculosTipo'] = Veiculos_tipoModel::list($params);
        } else {
            $dados['veiculosTipo'] = Veiculos_tipoModel::list();
        }

        if ($args['modo']??false == 'lista') {
            sleep(1);
            return $this->views->render($response, 'veiculos_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'veiculos_tipo.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }

    }

    /**
     * Salva um veiculoss.
     *
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

        $veiculos_tipo_id = $requests['veiculos_tipo_id'] ?? null;
        $empresas_id = $requests['empresas_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $marca = $requests['marca'] ?? null;
        $modelo = $requests['modelo'] ?? null;
        $ano = $requests['ano'] ?? null;
        $codigo = $requests['codigo'] ?? null;
        $placa = $requests['placa'] ?? null;

        $dados = [
            'veiculos_tipo_id' => $veiculos_tipo_id,
            'empresas_id' => $empresas_id,
            'nome' => $sanitize->string($nome)->doubles()->firstUp()->get(),
            'marca' => $sanitize->string($marca)->firstUp()->get(),
            'modelo' => $sanitize->string($modelo)->get(),
            'ano' => $sanitize->string($ano)->get(),
            'codigo' => $sanitize->string($codigo)->get(),
            'placa' => $sanitize->string($placa)->get(),
        ];

        $dados = array_filter($dados);

        if (!empty($id)) {
            $veiculoss = VeiculosModel::list(['veiculos.id' => $id]);
            if ($veiculoss->count()) {
                //  var_dump($list);exit;

                VeiculosModel::where(['id' => $id])->update($dados);
                $veiculoss = VeiculosModel::list(['veiculos.id' => $id]);

                return $response->withJson($veiculoss, true, 'Veiculos foi salvo');
            } else {
                return $response->withJson($requests, false, 'Veiculos não foi localizado');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['empresas_id', 'veiculos_tipo_id']);

            if ($v->validate()) {
                $veiculosInsert = VeiculosModel::create($dados);
                $veiculosNew = VeiculosModel::list(['veiculos.id' => $veiculosInsert->id]);

                return $response->withJson($veiculosNew, true, 'Veiculos foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }

    /**
     * Salva um tipo de veiculoss.
     *
     * @return string json
     */
    public function tipo_save(Request $request, Response $response, array $args)
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

        $nome = $requests['nome'] ?? null;
        $descricao = $requests['descricao'] ?? null;

        $dados = [
            'nome' => $sanitize->name($nome)->get(),
            'descricao' => $sanitize->string($descricao)->firstUp()->get(),
        ];

        if (!empty($id)) {
            $veiculos_tipos = Veiculos_tipoModel::list(['id' => $id]);
            if ($veiculos_tipos->count()) {
                //  var_dump($list);exit;

                Veiculos_tipoModel::where(['id' => $id])->update($dados);
                $veiculos_tipos = Veiculos_tipoModel::list(['id' => $id]);

                return $response->withJson($veiculos_tipos, true, 'Tipo de veiculos foi salvo');
            } else {
                return $response->withJson($requests, false, 'Tipo de veiculos não foi localizado');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['nome']);

            if ($v->validate()) {
                $veiculos_tipoInsert = Veiculos_tipoModel::create($dados);
                $veiculos_tipoNew = Veiculos_tipoModel::list(['id' => $veiculos_tipoInsert->id]);

                return $response->withJson($veiculos_tipoNew, true, 'Tipo de veiculos foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
