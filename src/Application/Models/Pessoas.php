<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Pessoas extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'endereco_id', 'nome', 'cpf_cnpj', 'natureza', 'documento', 'orgao_emissor', 'excluido', 'excluido_por', 'data_excluido'];
    public $timestamps = false;
    public $table = 'pessoas';

    /**
     * localiza e retorna um pessoas pelo campo passado em $params.
     *
     * @return Pessoas
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $pessoas = DB::table('pessoas');
        $pessoas->select('id', 'endereco_id', 'nome', 'cpf_cnpj', 'natureza', 'documento', 'orgao_emissor');
        if (isset($params['id'])) {
            $pessoas->where('id', $params['id']);
        }
        if (isset($params['nome'])) {
            $pessoas->where('nome', 'like', "%{$params['nome']}%");
        }
        if (isset($params['cpf_cnpj'])) {
            $pessoas->where('cpf_cnpj', '=', $params['cpf_cnpj']);
        }
        if (isset($params['documento'])) {
            $pessoas->where('documento', '=', $params['documento']);
        }
        $pessoas->where('pessoas.excluido', 'N');
        $result = $pessoas->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

    /**
     * localiza e retorna um pessoas pelo campo token.
     *
     * @return Pessoas
     */
    public static function auth(array $params, string $senha)
    {
        // DB::enableQueryLog();
        if (!empty($params) && !empty($senha)) {
            $pessoas = DB::table('pessoas');
            $pessoas->select('id', 'pessoas_id', 'pessoas', 'token', 'email', 'celular');

            foreach ($params as $campo => $param) {
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
     * localiza e retorna um pessoas pelo campo token.
     * Usado em CheckTokenMiddleware.
     *
     * @return Pessoas
     */
    public static function getUserByToken(string $token)
    {
        $pessoas = DB::table('pessoas');
        if (!empty($token)) {
            $pessoas->where('token', '=', $token);
            $result = $pessoas->get();

            return $result;
        }

        return false;
    }

    /**
     * Salva login na tabela pessoas_login.
     *
     * @return Pessoas
     */
    public static function login(array $dados)
    {
        // DB::enableQueryLog();
        if (!empty($dados)) {
            $pessoasLogin = DB::table('pessoas_login')->insert($dados);

            return $pessoasLogin;
        }

        return false;
    }
}
