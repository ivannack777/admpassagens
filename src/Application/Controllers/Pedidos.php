<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Pedidos as PedidosModel;
use App\Application\Models\Viagens as ViagensModel;
use App\Application\Models\Clientes as ClientesModel;
use App\Application\Models\Localidades as LocalidadesModel;
use App\Application\Models\LocalidadesLog as LocalidadesLogModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Pedidos extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um pedidos passando 'pedidos' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $requests = $request->getParsedBody();
        $codigo = $requests['codigo'] ?? null;
        $clientes_id = $requests['clientes_id'] ?? null;
        $viagens_id = $requests['viagens_id'] ?? null;
        $cpf = $requests['cpf'] ?? null;
        
        if (!empty($codigo)) {
            $params['pedidos.codigo'] = $codigo;
        }
        if (!empty($clientes_id)) {
            $params['pedidos.clientes_id'] = $clientes_id;
        }
        if (!empty($viagens_id)) {
            $params['pedidos.viagens_id'] = $viagens_id;
        }
        if (!empty($cpf)) {
            $params['pedidos.cpf'] = $cpf;
        }
        

        if (!empty($params)) {
            $dados['pedidos'] = PedidosModel::list($params);
        } else {
            $dados['pedidos'] = PedidosModel::list();
        }
        $dados['clientes'] = ClientesModel::list();
        $dados['viagens'] = ViagensModel::list();

        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'viagens_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'pedidos.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
    }

    /**
     * Salva um pedidos.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $clientes_id = $requests['clientes_id'] ?? null;
        $viagens_id = $requests['viagens_id'] ?? null;
        $cpf = $requests['cpf'] ?? null;
        $valor = $requests['valor'] ?? null;
        $status = $requests['status'] ?? null;
        
        $sanitize = new Sanitize();

        $dados = [
            'clientes_id' => $clientes_id,
            'viagens_id' => $viagens_id,
            'cpf' => $sanitize->number($cpf, 'clear')->get(),
            'valor' => $sanitize->decimal($valor, 2)->get(),
            'status' => $status,

        ];

        if (!empty($id)) {
            $pedidos = PedidosModel::list(['id' => $id]);
            if ($pedidos->count()) {
                //  var_dump($list);exit;

                PedidosModel::where(['id' => $id])->update($dados);
                $pedidos = PedidosModel::list(['id' => $id]);

                return $response->withJson($pedidos, true, 'Pedido foi salvo');
            } else {
                return $response->withJson($requests, false, 'Pedido não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['clientes_id']);
            if ($v->validate()) {
                // $PedidosModel = new PedidosModel();
                $pedidoMax = PedidosModel::where('excluido','N')->max('id');
                $pedidoMax++;
                
                $dados['codigo'] = date('ymd') . sprintf('%05s', $clientes_id) . sprintf('%05s', $pedidoMax) ;
                // var_dump($dados);exit;
                $pedidosInsert = PedidosModel::create($dados);
                $pedidosNew = PedidosModel::list(['pedidos.id' => $pedidosInsert->id]);

                $viagens = ViagensModel::where('id',$viagens_id)->first();
                // var_dump($viagens->origem_id, $viagens->destino_id);exit;
                $dados = [
                    'localidades_id' => $viagens->origem_id,
                    'direcao' => '1'
                ];
   
                return $response->withJson($pedidosNew, true, 'Pedido foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
