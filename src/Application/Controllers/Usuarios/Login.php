<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use App\Application\Controllers\BaseController;
use App\Application\Models\Usuarios;
use Monolog\Handler\RotatingFileHandler;
// use Psr\Http\Message\ResponseInterface as Response;
use Monolog\Logger;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Slim\Views\PhpRenderer;

class Login extends BaseController
{
    protected $container;
    protected $config;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    public static function static(Request $request, Response $response, array $args): Response
    {
        // your code to access items in the container... $this->container->get('');
        $response->getBody()->write('static');

        return $response;
    }

    /**
     * Localiza e retorna um usuarios passando 'usuario' por json request.
     *
     * @return string json
     */
    public function check(Request $request, Response $response)
    {
        $method = $request->getMethod();

        $requests = $request->getParsedBody();
        if (isset($requests['usuario'])) {
            $usuarios = Usuarios::list(['usuario' => $requests['usuario']]);
        } else {
            $usuarios = Usuarios::list();
        }

        return $response->withJson($usuarios, true, $usuarios->count() . ' usuário(s) encontrado(s)');
    }

    /**
     * Localiza e valida um usuarios passando 'usuario' e 'senha' por json request.
     *
     * @return string json
     */
    public function auth(Request $request, Response $response): Response
    {
        $body = preg_replace('/\s+/', '', $request->getBody() ?? null);
        $log = new Logger(__CLASS__ . '::' . __FUNCTION__ . $body);
        $log->pushHandler(new RotatingFileHandler($_ENV['ACCESS_LOG'], 5, Logger::DEBUG));
        $caminho = '';
        $headers = $request->getHeaders();
        foreach ($headers as $name => $values) {
            $caminho .= $name . ': ' . implode(', ', $values) . '; ';
        }
        $requests = array_map('trim', $request->getParsedBody() ?? []);

        $usuario = $requests['usuario'] ?? null;
        $email = $requests['email'] ?? null;
        $celular = $requests['celular'] ?? null;
        $senha = isset($requests['senha']) && !empty($requests['senha']) ? hash('sha256', $requests['senha']) : null;

        if (empty($usuario) && empty($email) && empty($celular)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos. Usuário ou e-mail ou celular é obrigatório', 401);
        }

        if (!empty($usuario)) {
            $param['usuario'] = $usuario;
        }
        if (!empty($email)) {
            $param['email'] = $email;
        }
        if (!empty($celular)) {
            $param['celular'] = $celular;
        }

        if (empty($senha)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos. A senha é obrigatória', 401);
        }

        $usuarios = Usuarios::auth($param, $senha);
        if ($usuarios->count() === 1) {
            $usuario = $usuarios[0];

            //Registra login na tabela usuarios_login
            $dados['usuario_id'] = $usuario->id;
            $dados['caminho'] = $caminho;
            $login = Usuarios::list(['id' => $usuario->id]);

            $log->info($caminho . 'Usuário autenticado');

            return  $response->withJson([$login], true, 'Usuário autenticado');
        } else {
            $log->info($caminho . 'Usuário não encontrado');

            return   $response->withJson([], true, 'Usuário não encontrado');
        }
    }
    
    public function loginForm(Request $request, Response $response): Response
    {
        $dados = [];
        $views = new PhpRenderer('../Views');
        $this->views->render($response, 'header.php', $dados);
        $views->render($response, 'login.php', $dados);
        return $this->views->render($response, 'footer.php', $dados);
    }

    public function registrarForm(Request $request, Response $response): Response
    {
        $dados = [];
        $views = new PhpRenderer('../Views');
        $this->views->render($response, 'header.php', $dados);
        $this->views->render($response, 'registro.php', $dados);
        return $this->views->render($response, 'footer.php', $dados);
    }

    public function resetsenhaForm(Request $request, Response $response): Response
    {
        $dados = [];
        
        $this->views->render($response, 'header.php', $dados);
        $this->views->render($response, 'resetsenha.php', $dados);
        return $this->views->render($response, 'footer.php', $dados);
    }

    /**
     * Localiza, autentica e registra login
     *
     * @return string json
     */
    public function login(Request $request, Response $response): Response
    {
        session_start();
        $requests = $request->getParsedBody();

        $usuario  = $requests['usuario'] ?? false;
        $email  = $requests['email'] ?? false;
        $celular = $requests['celular'] ?? false;
        $identificador = $requests['identificador'] ?? false;
        $senha  = $requests['senha'] ?? false;
        // $dados['push_token'] = preg_replace('/(ExponentPushToken\[)([\d\w]+)(\])/', '$2', $requests['push_token']) ?? null;
        $dados['field']['identificador']['value'] = $identificador;

        if ($usuario) {
            $params['usuario'] = $usuario;
        }
        if ($email) {
            $params['email'] = $email;
        }
        if ($celular) {
            $params['celular'] = $celular;
        }
        if ($identificador) {
            $params['identificador'] = $identificador;
        }

        if (!empty($params) && !empty($senha)) {
            $usuarios = Usuarios::list($params);

            if ($usuarios->count()) {
                $paramsAuth = [
                    'id' => $usuarios[0]->id,
                    'senha' => hash('sha256', $senha)
                ];
                $usuariosAuth = Usuarios::auth($paramsAuth);

                if ($usuariosAuth->count()) {
                    $_SESSION['admpassagens']['user'] = [
                                'id' => $usuarios[0]->id,
                                'usuario' => $usuarios[0]->usuario,
                                'email' => $usuarios[0]->email,
                                'celular' => $usuarios[0]->celular,
                                'token' => $usuarios[0]->token,
                                'nivel' => $usuarios[0]->nivel,
                    ];

                    //gravar log do login ;)
                    $usuariosDadosLog = [
                        'usuarios_id' => $usuarios[0]->id,
                        'uri' =>  $request->getUri(),
                        'direcao' => 'E', //Entrada
                    ];
                    
                    $usuariosLog = Usuarios::log($usuariosDadosLog);
                    
                    if ($usuariosLog) {
                        //verifica se 'rememberuri' existe na sessão 
                        $rememberuri = $_SESSION['admpassagens']['rememberuri'] ?? false;
                        //se exisitir faz o redirect para o endereço, senão redireciona para raiz
                        return $response->withHeader('Location', $rememberuri ? $rememberuri->getPath() : '/')->withStatus(302);
                    } else {
                        $dados['msg'] =  'Falha ao salvar login';
                        $this->views->render($response, 'header.php', $dados);
                        $this->views->render($response, 'login.php', $dados);
                        return $this->views->render($response, 'footer.php', $dados);
                        // return  $response->withJson([$usuariosLog], false, 'Falha ao salvar login');
                    }
                } else{
                    $dados['msg'] =  'Usuário não foi autenticado, verique sua senha!';
                    $this->views->render($response, 'header.php', $dados);
                    $this->views->render($response, 'login.php', $dados);
                    return $this->views->render($response, 'footer.php', $dados);
                    // return  $response->withJson($params, false, 'Usuário não foi autenticado, verique sua senha!', 403);    
                }
            } else {
                $dados['msg'] =  'Usuário não foi localizado!';
                $this->views->render($response, 'header.php', $dados);
                $this->views->render($response, 'login.php', $dados);
                return $this->views->render($response, 'footer.php', $dados);
                // return  $response->withJson($params, false, 'Usuário não foi localizado!', 401);
            }
        } else {
            $dados['status'] =  false;
            $dados['msg'] =  'Paramatros incorretos.';
            
            if(empty($identificador)){
                $dados['field']['identificador']['msg'] = 'Por favor, informe uma identificação';
            }
            if(empty($senha)) {
                $dados['field']['senha']['msg'] = 'Por favor, informe sua senha';
                
            }
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'login.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
            // return $response->withJson(['dados' => $requests], false, 'Paramatros incorretos.', 401);
        }
    }


    /**
     * Localiza, autentica e registra login
     *
     * @return string json
     */
    public function logout(Request $request, Response $response): Response
    {
        session_start();
        var_dump($_SESSION);
        if($_SESSION['admpassagens'] ?? false && $_SESSION['admpassagens'] ['user'] ?? false){
            $usuariosDadosLog = [
                'usuarios_id' => $_SESSION['admpassagens'] ['user']['id'],
                'uri' =>  $request->getUri(),
                'direcao' => 'S', //Saída
            ];
            unset($_SESSION['admpassagens'] ['user']);
            // session_destroy();
             //gravar log do logout ;)
            Usuarios::log($usuariosDadosLog);
            
        }
        
        return $response->withHeader('Location', '/usuarios/login/form')->withStatus(302);
    }
}
