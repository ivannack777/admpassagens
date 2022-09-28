<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Usuarios extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'pessoas_id', 'usuarios', 'senha', 'token', 'email', 'celular', 'nivel', 'excluido', 'excluido_por', 'data_excluido'];
    public $timestamps = false;
    public $table = 'usuarios';

    /**
     * localiza e retorna um usuarios pelo campo passado em $params.
     *
     * @return Usuarios
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $usuarios = DB::table('usuarios');
        $usuarios->select(
            'usuarios.id',
            'usuarios.key',
            'usuarios.pessoas_id',
            'usuarios.usuario',
            'usuarios.token',
            'usuarios.email',
            'usuarios.celular',
            'usuarios.nivel',
            'pessoas.nome',
            'pessoas.cpf_cnpj',
            'pessoas.documento',
        );
        $usuarios->join('pessoas', 'pessoas.id', '=', 'usuarios.pessoas_id', 'left');
        foreach($params as $campo => $param){
            if ($campo == 'identificador') {
                $usuarios->where('usuarios.usuario', $param);
                $usuarios->orWhere('usuarios.email', $param);
                $usuarios->orWhere('usuarios.celular', $param);
            } else {
                $usuarios->where('usuarios.'.$campo, $param);    
            }
        }
        
        
        $usuarios->where('usuarios.excluido', 'N');
        $result = $usuarios->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

    /**
     * localiza e retorna um usuarios pelo campo token.
     *
     * @return Usuarios
     */
    public static function auth(array $params)
    {
        // DB::enableQueryLog();
        if (!empty($params)) {
            $usuarios = DB::table('usuarios');
            $usuarios->select('id', 'usuario', 'token', 'email', 'celular', 'nivel');

            foreach ($params as $campo => $param) {
                $usuarios->where($campo, '=', $param);
            }
            // $usuarios->where('senha', '=', $params['senha']);
            $result = $usuarios->get();
            // var_dump(DB::getQueryLog());exit;
            return $result;
        }

        return false;
    }

    /**
     * localiza e retorna um usuarios pelo campo token.
     * Usado em CheckTokenMiddleware.
     *
     * @return Usuarios
     */
    public static function getUserByToken(string $token)
    {
        $usuarios = DB::table('usuarios');
        if (!empty($token)) {
            $usuarios->where('token', '=', $token);
            $result = $usuarios->get();

            return $result;
        }

        return false;
    }

    /**
     * Salva login na tabela usuarios_login.
     *
     * @return Usuarios
     */
    public static function log(array $dados)
    {
        // DB::enableQueryLog();
        if (!empty($dados)) {
            $usuariosLogin = DB::table('usuarios_log')->insert($dados);

            return $usuariosLogin;
        }

        return false;
    }
}
