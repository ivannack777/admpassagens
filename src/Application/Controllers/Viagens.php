<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Viagens as ViagenModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Viagens extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um viagenss passando 'viagens' por json request.
     *
     * @return string json
     */
    public function list(Request $request, Response $response)
    {
        $requests = $request->getParsedBody();

        $descricao = $requests['descricao'] ?? null;
        $origem = $requests['origem'] ?? null;
        $destino = $requests['destino'] ?? null;
        $data_saida = $requests['data_saida'] ?? null;
        $data_chegada = $requests['data_chegada'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id

        if (!empty($descricao)) {
            $params['descricao'] = $descricao;
        }
        if (!empty($origem)) {
            $params['origem'] = $origem;
        }
        if (!empty($destino)) {
            $params['destino'] = $destino;
        }
        if (!empty($data_saida)) {
            $params['data_saida'] = $data_saida;
        }
        if (!empty($data_chegada)) {
            $params['data_chegada'] = $data_chegada;
        }

        if (!empty($params)) {
            $viagens = ViagenModel::list($params);
        } else {
            $viagens = ViagenModel::list();
        }

        return $response->withJson($viagens, true, $viagens->count().($viagens->count() > 1 ? ' viagens encontradas' : ' viagen encontrada'));
    }

    /**
     * Salva um viagenss.
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
        $descricao = $requests['descricao'] ?? null;
        $origem = $requests['origem'] ?? null;
        $destino = $requests['destino'] ?? null;
        $data_saida = $requests['data_saida'] ?? null;
        $data_chegada = $requests['data_chegada'] ?? null;
        $detalhes = $requests['detalhes'] ?? null;
        $veiculos_id = $requests['veiculos_id'] ?? null;

        $sanitize = new Sanitize();

        $dados = array_filter([
            'descricao' => $descricao,
            'origem' => $origem,
            'destino' => $destino,
            'data_saida' => $data_saida,
            'data_chegada' => $data_chegada,
            'detalhes' => $detalhes,
            'veiculos_id' => $veiculos_id,
        ]);

        if (!empty($id)) {
            $viagens = ViagenModel::list(['viagens.id' => $id]);
            if ($viagens->count()) {
                ViagenModel::where(['viagens.id' => $id])->update($dados);
                $viagens = ViagenModel::list(['viagens.id' => $id]);

                return $response->withJson($viagens, true, 'Viagens foi salvo');
            } else {
                return $response->withJson($requests, false, 'Viagen não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['descricao', 'origem', 'destino', 'data_saida', 'data_chegada']);

            if ($v->validate()) {
                $viagenInsert = ViagenModel::create($dados);
                $viagenNew = ViagenModel::list(['viagens.id' => $viagenInsert->id]);

                return $response->withJson($viagenNew, true, 'Viagem foi adicionada');
            } else {
                // Errors
                $Errors = $this->valitorMessages($v->errors());

                return $response->withJson($dados, false, $Errors);
            }
        }
    }

    public function execute(Request $request, Response $response, array $args)
    {
        $hoje = new \DateTime('today');
        $agora = new \DateTime('now');
        //listar todas as viagens
        $viagens = ViagenModel::list();

        foreach ($viagens as $viagen) {
            //verificar por datas
            if (!empty($viagen->datas)) {
                $datasExp = explode(',', $viagen->datas);
                foreach ($datasExp as $data) {
                    try {
                        $dt = new \DateTime($data);
                        var_dump($dt);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
            }

            //verificar por repetições

            if (!empty($viagen->repeticao_tipo) && !empty($viagen->repeticao_detalhe)) {
                if ($viagen->repeticao_tipo == 'dia_semana') {
                    //veriricar qual dia da semana é hoje
                    $diaSemana = $hoje->format('w');
                    $repeticao_detalhe = explode(',', $viagen->repeticao_detalhe);
                    var_dump($diaSemana, $repeticao_detalhe);
                    if (in_array($diaSemana, $repeticao_detalhe)) {
                        echo 'Tem pra hoje, verificar horas...';
                        //verificar horários
                        $HorariosExp = explode(',', $viagen->horarios);
                        var_dump($HorariosExp);
                        foreach ($HorariosExp as $hora) {
                            $horaMin = explode(':', $hora);
                            $agora2 = clone $agora;
                            $agora2->setTime((int) $horaMin[0], (int) $horaMin[1], 0);
                            if ($agora->format('G') == $agora2->format('G') && $agora->format('i') == $agora2->format('i')) {
                                echo 'Ta na hora';
                                var_dump($agora, $agora2);
                            }
                        }
                    }
                }
            }
        }
        exit;

        return $response->withJson($viagens, true, $viagens->count().($viagens->count() > 1 ? ' viagens encontradas' : ' viagen encontrada'));
    }
}
