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

class Localidades extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um localidades passando 'localidades' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $uf = $requests['uf'] ?? null;
        $nome_uf = $requests['nome_uf'] ?? null;
        $sigla_uf = $requests['sigla_uf'] ?? null;
        
        $params['ibge_localidades.codigo_categoria'] = [
            1, //cidade
            2, //distrito
        ];
        
        if (!empty($nome)) {
            $params['ibge_localidades.nome'] = $nome;
        }
        if (!empty($uf)) {
            $params['ibge_localidades.uf'] = $uf;
        }
        if (!empty($nome_uf)) {
            $params['ibge_localidades.nome_uf'] = $nome_uf;
        }
        if (!empty($sigla_uf)) {
            $params['ibge_localidades.sigla_uf'] = $sigla_uf;
        }

        if (!empty($params)) {
            $localidades = LocalidadesModel::list($params);
        } else {
            $localidades = LocalidadesModel::list();
        }

        foreach($localidades as $localidade){
            if($localidade->localidade == $localidade->nome_municipio){
                $localidade->local = $localidade->nome_municipio .' - '. $localidade->sigla_uf;
            } else {
                $localidade->local = $localidade->localidade .'/'. $localidade->nome_municipio .' - '. $localidade->sigla_uf;
            }
        }

        return $response->withJson($localidades, true, $localidades->count().($localidades->count() > 1 ? ' localidades encontradas' : ' localidade encontrada'));
    }

    /**
     * Salva um localidades.
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
                return $response->withJson($requests, false, 'Localidades não foi localizada');
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
