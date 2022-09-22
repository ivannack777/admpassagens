<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Clientes extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','nome','cpf', 'celular','email' ];
    public $timestamps = false;
    public $table = 'clientes';

    /**
     * localiza e retorna um localidade pelo campo passado em $params.
     *
     * @return Enderecos
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $clientes = DB::table('clientes');
        $clientes->select(
            'clientes.id',
            'clientes.nome',
            'clientes.cpf',
            'clientes.celular',
            'clientes.email'
        );
        foreach ($params as $campo => $param) {
            $clientes->where($campo, '=' , $param);
        }
        $clientes->where('clientes.excluido', 'N');
        $result = $clientes->get();
        
        // var_export( DB::getQueryLog());
        // var_dump($params);exit;
        return $result;
    }

}
