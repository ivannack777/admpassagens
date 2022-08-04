<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Rotina as RotinaModel;
use App\Application\Helpers\Sanitize;

use Valitron\Validator;
use App\Application\Controllers\BaseController;
use Exception;

class Rotinas extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



    /**
     * Localiza e retorna um rotinass passando 'rotinas' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {


        $requests = $request->getParsedBody();
        $usuario_id = $requests['usuario_id'] ?? null;
        $nome = $requests['nome'] ?? null;
        $horarios = $requests['horarios'] ?? null;
        $datas = $requests['datas'] ?? null;
        $repeticoes = $requests['repeticoes'] ?? null;

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo usuario_id
        $userSession = $_SESSION['user'];
        if ($userSession['nivel'] == '1') {
            $params['usuario_id'] = $userSession['id'];
        } else {
            if (!empty($usuario_id)) {
                $params['usuario_id'] = $usuario_id;
            }
        }

        if (!empty($nome)) {
            $params['nome'] = $nome;
        }
        if (!empty($horarios)) {
            $params['horarios'] = $horarios;
        }
        if (!empty($datas)) {
            $params['datas'] = $datas;
        }
        if (!empty($repeticoes)) {
            $params['datas'] = $datas;
        }


        if (!empty($params)) {
            $rotinas = RotinaModel::list($params);
        } else {
            $rotinas = RotinaModel::list();
        }

        return $response->withJson($rotinas, true, $rotinas->count() . ($rotinas->count() > 1 ? ' rotinas encontradas' : ' rotina encontrada'));
    }



    /**
     * Salva um rotinass 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {

        $id = $args['id'] ?? null;
        $requests = $request->getParsedBody();
        if (empty($requests)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $usuario_id     = $requests['usuario_id'] ?? null;
        $cena_id        = $requests['cena_id'] ?? null;
        $nome           = $requests['nome'] ?? null;
        $horarios       = $requests['horarios'] ?? null;
        $datas          = $requests['datas'] ?? null;
        $repeticao_tipo = $requests['repeticao_tipo'] ?? null;
        $repeticao      = $requests['repeticao'] ?? null;

        /**
         * Explode as datas separadas por vírgual
         * Depois aplica o sanitize para 
         */
        if ($datas) {
            $datasArr = [];
            $sanitize = new Sanitize();
            $datasExp = explode(',', $datas);
            foreach ($datasExp as $data) {
                $datasArr[] = $sanitize->date($data, 'd/m/Y', 'Y-m-d');
            }
            $datas = implode(',', $datasArr);
        }

        if ($horarios) {
            $horariosArr = [];
            $sanitize = new Sanitize();
            $horariosExp = explode(',', $horarios);
            foreach ($horariosExp as $horario) {
                $horariosArr[] = $sanitize->date($horario, 'H:i', 'H:i');
            }
            $horarios = implode(',', $horariosArr);
        }

        $dados = [
            'usuario_id' => $usuario_id,
            'cena_id' => $cena_id,
            'nome' => $sanitize->string($nome)->get(),
            'horarios' => $horarios,
            'datas' => $datas,
            'repeticao_tipo' => $repeticao_tipo,
            'repeticao' => $repeticao,
        ];

        if (!empty($id)) {
            $rotinas = RotinaModel::list(['id' => $id]);
            if ($rotinas->count()) {
                //  var_dump($list);exit;

                RotinaModel::where(['id' => $id])->update($dados);
                $rotinas = RotinaModel::list(['id' => $id]);
                return $response->withJson($rotinas, true, 'Rotinas foi salvo');
            } else {
                return $response->withJson($requests, false, 'Rotina não foi localizada');
            }
        } else {
            $v = new Validator($dados);
            $v->rule('required', ['usuario_id', 'horario']);

            if (!empty($usuario_id) && !empty($horarios)) {
                $rotinaInsert = RotinaModel::create($dados);
                $rotinaNew = RotinaModel::list(['id' => $rotinaInsert->id]);
                return $response->withJson($rotinaNew, true, 'Rotina foi adicionado');
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
        //listar todas as rotinas
        $rotinas = RotinaModel::list();

        foreach ($rotinas as $rotina) {

            //verificar por datas
            if (!empty($rotina->datas)) {
                $datasExp = explode(",", $rotina->datas);
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

            if (!empty($rotina->repeticao_tipo) && !empty($rotina->repeticao_detalhe)) {
                if ($rotina->repeticao_tipo == 'dia_semana') {
                    //veriricar qual dia da semana é hoje
                    $diaSemana = $hoje->format('w');
                    $repeticao_detalhe = explode(",", $rotina->repeticao_detalhe);
                    var_dump($diaSemana, $repeticao_detalhe);
                    if(in_array($diaSemana, $repeticao_detalhe)){
                        echo "Tem pra hoje, verificar horas...";
                        //verificar horários
                        $HorariosExp = explode(",", $rotina->horarios);
                        var_dump($HorariosExp);
                        foreach ($HorariosExp as $hora) {
                            $horaMin = explode(":", $hora);
                            $agora2 = clone $agora;
                            $agora2->setTime((int)$horaMin[0], (int)$horaMin[1], 0);
                            if($agora->format('G') == $agora2->format('G') && $agora->format('i') == $agora2->format('i') ){
                                echo "Ta na hora";
                                var_dump($agora , $agora2);
                            }
                        }
                    }

                }
            }
        }
        exit;
        return $response->withJson($rotinas, true, $rotinas->count() . ($rotinas->count() > 1 ? ' rotinas encontradas' : ' rotina encontrada'));
    }
}
