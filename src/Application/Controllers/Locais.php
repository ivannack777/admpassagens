<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Localidades as LocalidadesModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Locais extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }


    /**
     * Localiza e retorna um localidades passando 'localidades' por json request.
     *
     * @return string json
     */
    public function home(Request $request, Response $response)
    {
        $requests = $this->getRequests($request);
        
        $apiResult = $this->api->post('locais/listar', $requests);
        $dados['locais'] = $apiResult;

        $apiResult = $this->api->post('locais/estados', $requests);
        $dados['estados'] = $apiResult;
        
        //usando $this->view setado em BaseController
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'locais_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'locais.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }

    }

    /**
     * Localiza e retorna um localidades passando 'localidades' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $requests = $this->getRequests($request);
        $apiResult = $this->api->post('locais/listar', $requests);
        if($apiResult){
            return $response->withJson($apiResult->data, $apiResult->status, $apiResult->msg);
        }
        return $response->withJson([], false, 'Erro na consulta', 500);
    }

    /**
     * Salva um localidades.
     *
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $requests = $this->getRequests($request);
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Par??metros incorretos.', 401);
        }
        $usuario_id = $requests['usuario_id'] ?? null;
        $empreendimento_id = $requests['empreendimento_id'] ?? null;
        $nome = $requests['nome'] ?? null;

        $sanitize = new Sanitize();

        $dados = [
            'usuario_id' => $usuario_id,
            'empreendimento_id' => $empreendimento_id,
            'nome' => $sanitize->name($nome, 'ucfirst')->get(),
        ];

        if (!empty($id)) {
            $localidades = LocalidadesModel::list(['id' => $id]);
            if ($localidades->count()) {
                //  var_dump($list);exit;

                LocalidadesModel::where(['id' => $id])->update($dados);
                $localidades = LocalidadesModel::list(['id' => $id]);

                return $response->withJson($localidades, true, 'Localidades foi salvo');
            } else {
                return $response->withJson($requests, false, 'Localidades n??o foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'empreendimento_id', 'nome']);

            if ($v->validate()) {
                $localidadesInsert = LocalidadesModel::create($dados);
                $localidadesNew = LocalidadesModel::list(['id' => $localidadesInsert->id]);

                return $response->withJson($localidadesNew, true, 'Localidades foi adicionado');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }
}
