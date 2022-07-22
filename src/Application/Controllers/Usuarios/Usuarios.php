<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Usuario as UsuarioModel;
use App\Application\Models\Pessoa as PessoaModel;

use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Usuarios extends BaseController
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
     * Salva um usuario
     * Se passar o id pela URL faz update, senão faz insert
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function save(Request $request, Response $response, array $args)
    {
        $id = $args['id'] ?? null;
        $sanitize = new Sanitize();
        $requests = $request->getParsedBody();
        if(empty($requests)){
            return  $response->withJson($requests, false, 'Parâmetros incorretos.', 401);
        }
        $usuario = $requests['usuario']??null;
        $email = $requests['email']??null;
        $celular = $requests['celular']??null;
        $senha = $requests['senha']??null;
        $token = $requests['token']??null;
        $pessoa_id = $requests['pessoa_id']??null;

     

        $dados=[
            'usuario' => $usuario,
            'email' => $email,
            'celular' => $celular,
            'senha' => $senha,
            'token' => $token,
            'pessoa_id' => $pessoa_id,
        ];

        if (!empty($pessoa_id)) {
            $pessoas = PessoaModel::list(['id'=>$pessoa_id]);
            if($pessoas->count()===0){
                return $response->withJson($dados, false, 'Pessoa não encontrada pelo pessoa_id: '. $pessoa_id);
            }
         
        }
        if (!empty($id)) {
            $usuarios = UsuarioModel::list(['id' => $id]);
            if ($usuarios->count()) {
                UsuarioModel::where(['id' => $id])->update($dados);
                $usuarios = UsuarioModel::list(['id' => $id]);
                return $response->withJson($dados, true, 'Usuario foi salvo');
            } else {
                return $response->withJson($requests, false, 'Usuario não foi localizado');
            }
        } else {
            $v = new Validator($dados);

            $v->rules([
                'requiredWithout' => [
                    ['usuario', ['email', 'celular'], true] //se não existir email ou celular, usuario será obrigatorio
                ],
                'requiredWith' => [
                    ['password', ['usuario']] //se existir usuario, então senha será obrigatorio
                ],
                'email' => [
                    ['email']
                ],
                'optional' => [
                    ['email','celular'] // email ou celular são opcionais, (porem será obrigatorio no parametro requiredWithout se usuário não existir)
                ]
            ]);
            

            if ($v->validate()) {

                $dados = array_filter($dados);
                $usuarios = UsuarioModel::list($dados);
                if ($usuarios->count()) {
                    return $response->withJson($dados, false, 'Já existe um usuário com esta identificação');    
                }
                $usuarioInsert = UsuarioModel::create($dados);
                $usuarioNew = UsuarioModel::list(['id' => $usuarioInsert->id]);
                return $response->withJson($usuarioNew, true, 'Usuario foi adicionado');
            } else {
                echo "Nok";
                // exit;
                 // Errors
                 $Errors = $this->valitorMessages($v->errors());
                 return $response->withJson($dados, false,$Errors);
            }
        }

        return $response->withJson(false, true, ' usuário foi salvo');

    
    }


}
