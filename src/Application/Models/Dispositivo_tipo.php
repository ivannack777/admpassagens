<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Dispositivo_tipo extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    public $table = 'dispositivo_tipo';
    

    /**
     * localiza e retorna um dispositivo_tipo pelo campo passado em $params
     * @param array $params
     * @return Dispositivo_tipos
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $dispositivo_tipos = DB::table('dispositivo_tipo');
        $dispositivo_tipos->select('*');
        foreach($params as $campo => $param){
            $dispositivo_tipos->where($campo, '=', $param);
        }

        $result = $dispositivo_tipos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

   
    /**
     * localiza e retorna um dispositivo_tipo pelo campo token
     * @param string $dispositivo_tipo
     * @param string $senha
     * @return Dispositivo_tipos
     */
    static public function auth(array $params, string $senha)
    {
        // DB::enableQueryLog();
        if(!empty($params) && !empty($senha)){
            $dispositivo_tipos = DB::table('dispositivo_tipo');
            $dispositivo_tipos->select('id','pessoa_id', 'dispositivo_tipo','token','email','celular');

            foreach($params as $campo => $param){
                $dispositivo_tipos->where($campo, '=', $param);
            }
            $dispositivo_tipos->where('senha', '=', $senha);
            $result = $dispositivo_tipos->get();
            // var_dump(DB::getQueryLog());exit;
            return $result;
        }
        return false;
    }

    /**
     * localiza e retorna um dispositivo_tipo pelo campo token.
     * Usado em CheckTokenMiddleware
     * @param string $token
     * @return Dispositivo_tipos
     */
    static public function getUserByToken(string $token)
    {
        $dispositivo_tipos = DB::table('dispositivo_tipo');
        if(!empty($token)){
            $dispositivo_tipos->where('token', '=', $token);
            $result = $dispositivo_tipos->get();
            return $result;
        }
        
        return false;
    }


    /**
     * Salva login na tabela dispositivo_tipo_login 
     * @param string $dispositivo_tipo
     * @param string $senha
     * @return Dispositivo_tipos
     */
    static public function login(array $dados)
    {
        // DB::enableQueryLog();
        if(!empty($dados)){
            $dispositivo_tiposLogin = DB::table('dispositivo_tipo_login')->insert($dados);
            
            return $dispositivo_tiposLogin;
        }
        return false;
    }

}