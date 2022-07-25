<?php

declare(strict_types=1);

namespace App\Application\Controllers\Usuarios;

use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use App\Application\Models\Usuario;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
class Login 
{
    protected $container;
    protected $config;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    static public function static(Request $request, Response $response, array $args): Response
    {
        // your code to access items in the container... $this->container->get('');
        $response->getBody()->write('static');
        return $response;
    }

    /**
     * Localiza e retorna um usuarios passando 'usuario' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function check(Request $request, Response $response)
    {

        $method = $request->getMethod();

        $requests = $request->getParsedBody();
        if (isset($requests['usuario'])) {
            $usuarios = Usuario::list(['usuario' => $requests['usuario']]);
        } else {
            $usuarios = Usuario::list();
        }

        return $response->withJson($usuarios, true, $usuarios->count() . ' usuário(s) encontrado(s)');

    
    }

    /**
     * Localiza e valida um usuarios passando 'usuario' e 'senha' por json request
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function auth(Request $request, Response $response): Response
    {

        $body = preg_replace('/\s+/','',$request->getBody()??null);
        $log = new Logger(__CLASS__ ."::". __FUNCTION__ . $body);
        $log->pushHandler(new RotatingFileHandler($_ENV['ACCESS_LOG'], 5, Logger::DEBUG));
        $caminho='';
        $headers = $request->getHeaders();
        foreach ($headers as $name => $values) {
            $caminho .= $name . ": " . implode(", ", $values)."; ";
        }
        $requests = array_map('trim', $request->getParsedBody() ?? []);

        $usuario = $requests['usuario'] ?? null;
        $email = $requests['email'] ?? null;
        $celular = $requests['celular'] ?? null;
        $senha = isset($requests['senha']) && !empty($requests['senha']) ? hash('sha256', $requests['senha']) : null;

        if (empty($usuario) && empty($email) && empty($celular)) {
            return  $response->withJson($requests, false, 'Parâmetros incorretos. Usuario ou e-mail ou celar é obrigatório', 401);
        }

        if (!empty($usuario))  {
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
        
        $usuarios = Usuario::auth($param, $senha);
        if ($usuarios->count() === 1) {
            $usuario = $usuarios[0];

            //Registra login na tabela usuarios_login 
            $dados['usuario_id'] = $usuario->id;
            $dados['caminho'] = $caminho;
            $login = Usuario::login($dados);

            $log->info($caminho.'Usuário autenticado');
    
            return  $response->withJson([$usuario,$login], true, 'Usuário autenticado');
        } else {
            $log->info($caminho.'Usuário não encontrado');
            return   $response->withJson([], true, 'Usuário não encontrado');
        }
    
    }


    /**
     * Registra login na tabela usuarios_login 
     * @param Request $request
     * @param Response $response
     * @return string json
     */
    public function login(Request $request, Response $response): Response
    {

        $requests = array_map('trim', $request->getParsedBody() ?? []);

        $dados['usuarios_id'] = $requests['usuario_id'] ?? null;
        $dados['device_id'] = $requests['device_id'] ?? null;
        $dados['push_token'] = preg_replace('/(ExponentPushToken\[)([\d\w]+)(\])/', '$2', $requests['push_token']) ?? null;
        
        if ($dados['usuarios_id']) {

            $usuariosLog = Usuario::login($dados);
            if($usuariosLog){
                return  $response->withJson($usuariosLog, true, 'Login foi salvo');
            } else {
                return  $response->withJson($usuariosLog, false, 'Falha ao salvar login');
            }

        }
        else{
            return $response->withJson(["dados"=>$requests], false, 'Paramatros incorretos', 401);
        }
    }

}
