<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Illuminate\Database\Capsule\Manager as DB;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use App\Application\Models\ApiCall;

class ExcluirController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request.
     *
     * @return string $str
     */
    public function exclude(Request $request, Response $response, array $args)
    {

        $nivel = $_SESSION['user']['nivel']??0;
        if ($nivel < '3') {
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }
        
        $id = $args['id'] ?? null;

        $api = new ApiCall();
        $apiResult = $api->post('comentarios/excluir/'.$id);

        // var_dump($apiResult->data);exit;
        
        return $response->withJson($apiResult->data, true, ($apiResult->msg) );


        
        $tabela = null;
        $uriPath = $request->getUri()->getPath();
        $segments = explode('/', $uriPath);
        switch ($segments[1]) {
            case 'usuarios':
                $tabela = 'usuarios';
                if ($segments[2] == 'pessoas') {
                    $tabela = 'pessoas';
                }
                break;
            case 'veiculos':
                $tabela = 'veiculos';
                if ($segments[2] == 'tipo') {
                    $tabela = 'veiculos_tipo';
                }
                break;

            case 'viagens':
                $tabela = 'viagens';
                break;
            case 'clientes':
                $tabela = 'clientes';
                break;
            case 'pedidos':
                $tabela = 'pedidos';
                break;
            case 'enderecos':
                $tabela = 'endereco';
                break;
            case 'empresas':
                $tabela = 'empresas';
                break;
            case 'comentarios':
                $tabela = 'comentarios';
                break;
            default:
                $tabela = false;
                break;
        }
        if (empty($tabela)) {
            return $response->withJson($segments, false, 'Tabela não identificada pela rota');
        }
        if (empty($id)) {
            return $response->withJson($id, false, 'ID inválido');
        }


        //  DB::enableQueryLog();
        $tabela = DB::table($tabela);
        $tabela->where('id', '=', $id);
        $result = $tabela->get();
        // var_dump( DB::getQueryLog());
        // var_dump($result, $_SESSION['user']['id']);exit;

        if ($result->count() === 0) {
            return $response->withJson($result, false, 'Não foi localizado');
        } else {
            $dados = [
                'excluido' => 'S',
                'excluido_por' => $_SESSION['user']['id'],
                'excluido_data' => date('Y-m-d H:i:s'),
            ];
            $tabela->where('id', '=', $id)->update($dados);
            $result = $tabela->select('id', 'excluido', 'excluido_por', 'excluido_data')->where('id', '=', $id)->get();

            return $response->withJson($result, true, 'Foi excluído');
        }
    }
}
