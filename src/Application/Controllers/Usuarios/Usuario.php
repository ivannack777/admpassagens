<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Usuario as UsuarioModel;

use App\Application\Actions\ActionPayload;

class Usuario
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }



    /**
     * Localiza e retorna um usuarios passando 'usuario' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function list(Request $request, Response $response)
    {

        $method = $request->getMethod();

        $requests = $request->getParsedBody();
        $usuario = $requests['usuario']??null;
        $email = $requests['email']??null;
        $celular = $requests['celular']??null;

        if (!empty($usuario))  {
            $params['usuario'] = $usuario;
        }
        if (!empty($email)) {
            $params['email'] = $email;
        }
        if (!empty($celular)) {
            $params['celular'] = $celular;
        }

        if (!empty($params)) {
            $usuarios = UsuarioModel::list($params);
        } else {
            $usuarios = UsuarioModel::list();
        }

        return $response->withJson($usuarios, true, $usuarios->count() . ' usuário(s) encontrado(s)');

    
    }



    /**
     * Localiza e retorna um usuarios passando 'usuario' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response)
    {

        $requests = $request->getParsedBody();
        if(empty($requests)){
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $usuario = $requests['usuario']??null;
        $email = $requests['email']??null;
        $celular = $requests['celular']??null;
        $senha = $requests['senha']??null;
        $token = $requests['token']??null;



        if (!empty($usuario) || !empty($email) || !empty($celular)) {
            $dados=[
                'usuario' => $usuario,
                'email' => $email,
                'celular' => $celular,
                'senha' => $senha,
                'token' => $token,
            ];
            $list = json_decode($this->list($request, $response)->getBody()->__toString());
            //  var_dump($list);exit;
            if(count($list->data)){
                
                $usuariosResult = UsuarioModel::where(['id' => $list->data[0]->id])->update($dados);
                return $response->withJson($list->data[0], true, ' usuário foi salvo');
            } else {
                $usuariosResult = UsuarioModel::insert($dados);
                return $response->withJson($dados, true, ' usuário foi adicionado');
            }
            
        }

        return $response->withJson(false, true, ' usuário foi salvo');

    
    }


}
