<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Usuarios as UsuariosModel;
use App\Application\Models\Pessoas as PessoasModel;

use App\Application\Helpers\Sanitize;
use Valitron\Validator;
use App\Application\Controllers\BaseController;

class Usuarios extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }



    /**
     * Localiza e retorna um Usuarios passando 'usuario' por json request
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
        $Usuarios = [];

        //se o nivel do Usuarios for 1: cliente, sempre faz filtro pelo id
        if ($this->getUserSession('nivel') < '3') {
            // return $response->withJson([], false, 'Acesso não autorizado',403);  
            $this->views->render($response, 'header.php');
            $this->views->render($response, 'left.php');
            $this->views->render($response, 'right_top.php');
            $this->views->render($response, "403.php");
            return $this->views->render($response, 'footer.php');
        } 

        if ($this->getUserSession('id')) {
            $params['id'] = $this->getUserSession('id');
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
            $dados['usuarios'] = UsuariosModel::list($params);
        } else {
            $dados['usuarios'] = UsuariosModel::list();
        }
        

        //return $response->withJson($Usuarios, true, $Usuarios->count() . ($Usuarios->count()>1?' usuários encontrados':' usuário encontrado'));
        if ($args['modo']??false == 'lista') {
            return $this->views->render($response, 'veiculos_list.php', $dados);
        } else {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'usuarios.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
    }



    /**
     * Salva um Usuarios
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
            return  $response->withJson([], false, 'Parâmetros incorretos.', 401);
        }
        $usuario = $sanitize->username($requests['usuario']??null)->get();
        $email = $sanitize->email($requests['email']??null)->get();
        $celular = $sanitize->number($requests['celular']??null, 'clear')->get();
        $senha = $sanitize->password($requests['senha']??null)->get();
        $resenha = $sanitize->password($requests['resenha']??null)->get();
        $pessoas_id = $sanitize->integer($requests['pessoas_id']??null)->get();
        $nivel = $sanitize->integer($requests['nivel']??null)->get();
        
        if (!empty($senha)) {

            if ($this->getUserSession('nivel') < '5') {
                return $response->withJson([], false, 'Acesso não autorizado',403);  
            } 
            if ($senha != $resenha) {
                return $response->withJson([], false, 'As senhas não coincidem');
            }
            $dados = ['senha' => hash('sha256', $senha)];
        } else {
            //percorre todos os campos substituido vazios por null
            $dados = array_map(function($v){
                return empty($v)? null:$v;
            },[
                'usuario' => $usuario,
                'email' => $email,
                'celular' => $celular,
                'senha' => !empty($senha)?hash('sha256', $senha):null,
                'pessoas_id' => $pessoas_id,
                'nivel' => $nivel,
            ]);
        }



        if (!empty($pessoas_id)) {
            $pessoas = PessoasModel::list(['id'=>$pessoas_id]);
            if($pessoas->count()===0){
                return $response->withJson($dados, false, 'Pessoas não encontrada pelo pessoas_id: '. $pessoas_id);
            }
         
        }
        if (!empty($id)) {
            $Usuarios = UsuariosModel::list(['id' => $id]);
            if ($Usuarios->count()) {
                UsuariosModel::where(['id' => $id])->update($dados);
                $Usuarios = UsuariosModel::list(['id' => $id]);
                return $response->withJson($Usuarios, true, 'Usuario foi salvo');
            } else {
                return $response->withJson($requests, false, 'Usuario não foi localizado');
            }
        } else {

            # definindo linguagem do validador
            Validator::lang('pt-br');
            $v = new Validator($dados);

            // $v->rules([
            //     'requiredWithout' => [
            //         ['usuario', ['email', 'celular'], true, 'msg'] //se não existir email ou celular, Usuarios será obrigatorio
            //     ],
            //     'requiredWith' => [
            //         ['password', ['usuario']] //se existir Usuarios, então senha será obrigatorio
            //     ],
            //     'email' => [
            //         ['email']
            //     ],
            //     'optional' => [
            //         ['email','celular'] // email ou celular são opcionais, (porem será obrigatorio no parametro requiredWithout se usuário não existir)
            //     ]
            // ]);
            
            //se não existir email ou celular, Usuarios será obrigatorio
            $v->rule('requiredWithout' , 'usuario', ['email', 'celular'])->message('Se não existir email ou celular, usuario é obrigatorio');
            $v->rule('requiredWithout' , 'email', ['usuario', 'celular'])->message('Se não existir email ou celular, email é obrigatorio');
            $v->rule('requiredWithout' , 'celular', ['usuario', 'email'])->message('Se não existir email ou celular, celular é obrigatorio');
            
            //se existir Usuarios, então senha será obrigatorio
            $v->rule('requiredWith' , 'senha' ,['usuario'] )->message('senha é obrigatório junto com Usuarios');
            
            //aplicar validação de e-mail para o campo ['email']
            $v->rule('email' , ['email']);
            
            // email ou celular são opcionais, (porem será obrigatorio no parametro requiredWithout se usuário não existir)
            $v->rule('optional' , ['email','celular'] );            


            if ($v->validate()) {

                $dados = array_filter($dados);
                $Usuarios = UsuariosModel::list($dados);
                if ($Usuarios->count()) {
                    return $response->withJson($dados, false, 'Já existe um usuário com esta identificação');    
                }
                
                $dados['token'] = hash('sha256', $usuario.$email.$celular.time());
                $usuarioInsert = UsuariosModel::create($dados);
                $usuarioNew = UsuariosModel::list(['id' => $usuarioInsert->id]);
                return $response->withJson($usuarioNew, true, 'Usuario foi adicionado');
            } else {
                // exit;
                // Errors
                $Errors = $this->valitorMessages($v->errors());
                return $response->withJson($dados, false,$Errors);
            }
        }

        return $response->withJson([], true, ' usuário foi salvo');

    
    }


}
