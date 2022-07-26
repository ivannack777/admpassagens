<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Psr\Container\ContainerInterface;
use \Illuminate\Database\Capsule\Manager as DB;

class ExcluirController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request
     * @param array $errorsMessage
     * @param string $separator
     * @return string $str
     */
    public function exclude(Request $request, Response $response, array $args)
    {
        $nivel = $_SESSION['user']['nivel'];
        if($nivel == '1'){
            return $response->withJson([], true, 'Sem permissão para acessar esta área', 403);
        }
        
        $id = $args['id'] ?? null;
        $tabela = null;
        $uriPath = $request->getUri()->getPath();
        $segments = explode('/', $uriPath);
        switch ($segments[1]) {
            case 'users':
                $tabela = "usuario";
                break;
            case 'dispositivos':
                $tabela = "dispositivo";
                break;
            case 'cenas':
                $tabela = "cena";
                break;
            case 'rotinas':
                $tabela = "rotina";
                break;
            case 'enderecos':
                $tabela = "endereco";
                break;
            case 'empreendimentos':
                $tabela = "empreendimento";
                break;
            default:
                $tabela = false;
                break;
        }
        if (empty($tabela)) {
            return $response->withJson($result, false, 'Tabela não identificada pela rota');
        }
        if (empty($id)) {
            return $response->withJson($result, false, 'ID inválido');
        }



        //  DB::enableQueryLog();
        $tabela = DB::table($tabela);
        $tabela->where('id', '=', $id);
        $result = $tabela->get();
        // var_dump( DB::getQueryLog());
        // var_dump($result, $_SESSION['user']['id']);


        if (empty($result)) {
            return $response->withJson($result, false, 'não foi localizado');
        } else {
            $dados = [
                "excluido" => "S",
                "excluido_por" => $_SESSION['user']['id'],
                "data_excluido" => date('Y-m-d H:i:s'),

            ];
            $tabela->where('id', '=', $id)->update($dados);
            return $response->withJson($result, true, 'Empreendimentos foi salvo');
        }
    }
}
