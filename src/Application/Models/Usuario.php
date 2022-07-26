<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Usuario extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','pessoa_id','usuario','senha','token','email','celular','nivel','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'usuario';
    

    /**
     * localiza e retorna um usuario pelo campo passado em $params
     * @param array $params
     * @return Usuarios
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $usuarios = DB::table('usuario');
        $usuarios->select(
            'usuario.id',
            'usuario.pessoa_id',
            'usuario.usuario',
            'usuario.token',
            'usuario.email',
            'usuario.celular',
            'pessoa.nome',
            'pessoa.cpf_cnpj',
            'pessoa.documento',
        );
        if(isset($params['id'])){
            $usuarios->where('usuario.id', $params['id']);
        }
        if(isset($params['usuario'])){
            $usuarios->where('usuario.usuario', '=', $params['usuario']);
        }
        if(isset($params['email'])){
            $usuarios->where('usuario.email', '=', $params['email']);
        }
        if(isset($params['celular'])){
            $usuarios->where('usuario.celular', '=', $params['celular']);
        }

        $usuarios->join('pessoa', 'usuario.pessoa_id','=', 'pessoa.id','left');
        $result = $usuarios->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

   
    /**
     * localiza e retorna um usuario pelo campo token
     * @param string $usuario
     * @param string $senha
     * @return Usuarios
     */
    static public function auth(array $params, string $senha)
    {
        // DB::enableQueryLog();
        if(!empty($params) && !empty($senha)){
            $usuarios = DB::table('usuario');
            $usuarios->select('id','pessoa_id', 'usuario','token','email','celular','nivel');

            foreach($params as $campo => $param){
                $usuarios->where($campo, '=', $param);
            }
            $usuarios->where('senha', '=', $senha);
            $result = $usuarios->get();
            // var_dump(DB::getQueryLog());exit;
            return $result;
        }
        return false;
    }

    /**
     * localiza e retorna um usuario pelo campo token.
     * Usado em CheckTokenMiddleware
     * @param string $token
     * @return Usuarios
     */
    static public function getUserByToken(string $token)
    {
        $usuarios = DB::table('usuario');
        if(!empty($token)){
            $usuarios->where('token', '=', $token);
            $result = $usuarios->get();
            return $result;
        }
        
        return false;
    }


    /**
     * Salva login na tabela usuario_login 
     * @param string $usuario
     * @param string $senha
     * @return Usuarios
     */
    static public function login(array $dados)
    {
        // DB::enableQueryLog();
        if(!empty($dados)){
            $usuariosLogin = DB::table('usuario_login')->insert($dados);
            
            return $usuariosLogin;
        }
        return false;
    }

}