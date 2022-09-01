<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Enderecos extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['cep', 'logradouro', 'numero', 'complemento', 'uf', 'cidade', 'pais'];
    public $timestamps = false;
    public $table = 'enderecos';

    /**
     * localiza e retorna um endereco pelo campo passado em $params.
     *
     * @return Enderecos
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $enderecos = DB::table('enderecos');
        $enderecos->select('id', 'cep', 'logradouro', 'numero', 'complemento', 'uf', 'cidade', 'pais');
        foreach ($params as $campo => $param) {
            $enderecos->where($campo, '=', $param);
        }
        $result = $enderecos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }
}
