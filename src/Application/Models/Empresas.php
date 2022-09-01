<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Empresas extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['usuarios_id', 'enderecos_id', 'nome'];
    public $timestamps = false;
    public $table = 'empresas';

    /**
     * localiza e retorna um empresas pelo campo passado em $params.
     *
     * @return Empresas
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $empresas = DB::table('empresas');
        $empresas->select('id', 'usuarios_id', 'enderecos_id', 'nome');
        foreach ($params as $campo => $param) {
            if ($campo == 'nome') {
                $empresas->where($campo, 'like', "%{$param}%");
            } else {
                $empresas->where($campo, '=', $param);
            }
        }
        $result = $empresas->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }
}
