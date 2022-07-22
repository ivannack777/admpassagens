<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Pessoa extends \Illuminate\Database\Eloquent\Model
{

    protected $fillable = ['id','endereco_id','nome','cpf_cnpj','natureza','documento','orgao_emissor','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'pessoa';
    

    /**
     * localiza e retorna um pessoa pelo campo passado em $params
     * @param array $params
     * @return Pessoas
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $pessoas = DB::table('pessoa');
        $pessoas->select('id','endereco_id','nome','cpf_cnpj','natureza','documento','orgao_emissor');
        if(isset($params['id'])){
            $pessoas->where('id', $params['id']);
        }
        if(isset($params['nome'])){
            $pessoas->where('nome', 'like', "%{$params['nome']}%");
        }
        if(isset($params['cpf_cnpj'])){
            $pessoas->where('cpf_cnpj', '=', $params['cpf_cnpj']);
        }
        if(isset($params['documento'])){
            $pessoas->where('documento', '=', $params['documento']);
        }

        $result = $pessoas->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

   
    /**
     * localiza e retorna um pessoa pelo campo token
     * @param string $pessoa
     * @param string $senha
     * @return Pessoas
     */
    static public function auth(array $params, string $senha)
    {
        // DB::enableQueryLog();
        if(!empty($params) && !empty($senha)){
            $pessoas = DB::table('pessoa');
            $pessoas->select('id','pessoa_id', 'pessoa','token','email','celular');

            foreach($params as $campo => $param){
                $pessoas->where($campo, '=', $param);
            }
            $pessoas->where('senha', '=', $senha);
            $result = $pessoas->get();
            // var_dump(DB::getQueryLog());exit;
            return $result;
        }
        return false;
    }

    /**
     * localiza e retorna um pessoa pelo campo token.
     * Usado em CheckTokenMiddleware
     * @param string $token
     * @return Pessoas
     */
    static public function getUserByToken(string $token)
    {
        $pessoas = DB::table('pessoa');
        if(!empty($token)){
            $pessoas->where('token', '=', $token);
            $result = $pessoas->get();
            return $result;
        }
        
        return false;
    }


    /**
     * Salva login na tabela pessoa_login 
     * @param string $pessoa
     * @param string $senha
     * @return Pessoas
     */
    static public function login(array $dados)
    {
        // DB::enableQueryLog();
        if(!empty($dados)){
            $pessoasLogin = DB::table('pessoa_login')->insert($dados);
            
            return $pessoasLogin;
        }
        return false;
    }

}