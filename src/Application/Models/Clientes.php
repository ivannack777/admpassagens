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
        $selectArr = [
            'clientes.id',
            'clientes.nome',
            'clientes.cpf',
            'clientes.celular',
            'clientes.email'
        ];

        foreach ($params as $campo => $param) {
            $clientes->where($campo, '=' , $param);
        }

        
        if(isset($_SESSION['user'])){
            array_push($selectArr, 'favoritos.id as favoritos_id');
            $clientes->join('favoritos', function($join){

                $join->on("favoritos.item_id", '=', "clientes.id")
                ->where('favoritos.item', '=', 'clientes')
                ->where('favoritos.usuario_id', '=', $_SESSION['user']['id']);
            }, null,  null,'left');
        }

        $clientes->select($selectArr);

        $clientes->where('clientes.excluido', 'N');
        $result = $clientes->get();
        
        // var_export( DB::getQueryLog());
        // var_dump($params);exit;
        return $result;
    }

}
