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
        $id = $requests['id']??null;
        $usuario = $requests['usuario']??null;
        $email = $requests['email']??null;
        $celular = $requests['celular']??null;
        $usuarios = [];

        //se o nivel do usuario for 1: cliente, sempre faz filtro pelo id
        $userSession = $_SESSION['user'];
        if ($userSession['nivel'] == '1') {
            $params['id'] = $userSession['id'];
        } 

        if (!empty($id))  {
            $params['id'] = $id;
        }
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
        $usuario = $sanitize->username($requests['usuario']??null)->get();
        $email = $sanitize->email($requests['email']??null)->get();
        $celular = $sanitize->number($requests['celular']??null, 'clear')->get();
        $senha = $sanitize->password($requests['senha']??null)->get();
        $pessoa_id = $sanitize->integer($requests['pessoa_id']??null)->get();
        $nivel = $sanitize->integer($requests['nivel']??null)->get();
        $token = hash('sha256', $usuario. time());

     

        $dados=[
            'usuario' => $usuario,
            'email' => $email,
            'celular' => $celular,
            'senha' => !empty($senha)?hash('sha256', $senha):null,
            'token' => $token,
            'pessoa_id' => $pessoa_id,
            'nivel' => $nivel,
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

            # definindo linguagem do validador
            Validator::lang('pt-br');
            $v = new Validator($dados);

            // $v->rules([
            //     'requiredWithout' => [
            //         ['usuario', ['email', 'celular'], true, 'msg'] //se não existir email ou celular, usuario será obrigatorio
            //     ],
            //     'requiredWith' => [
            //         ['password', ['usuario']] //se existir usuario, então senha será obrigatorio
            //     ],
            //     'email' => [
            //         ['email']
            //     ],
            //     'optional' => [
            //         ['email','celular'] // email ou celular são opcionais, (porem será obrigatorio no parametro requiredWithout se usuário não existir)
            //     ]
            // ]);
            
            //se não existir email ou celular, usuario será obrigatorio
            $v->rule('requiredWithout' , 'usuario', ['email', 'celular'])->message('Se não existir email ou celular, usuario será obrigatorio');
            
            //se existir usuario, então senha será obrigatorio
            $v->rule('requiredWith' , 'senha' ,['usuario'] )->message('senha é obrigatório junto com usuario');
            
            //aplicar validação de e-mail para o campo ['email']
            $v->rule('email' , ['email']);
            
            // email ou celular são opcionais, (porem será obrigatorio no parametro requiredWithout se usuário não existir)
            $v->rule('optional' , ['email','celular'] );            


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
