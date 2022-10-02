<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Pedidos extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','codigo','clientes_id', 'viagens_id','valor' ];
    public $timestamps = false;
    public $table = 'pedidos';

    /**
     * localiza e retorna um localidade pelo campo passado em $params.
     *
     * @return Enderecos
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $pedidos = DB::table('pedidos');
        $selectArr = [
            'pedidos.id',
            'pedidos.codigo',
            'pedidos.clientes_id',
            'pedidos.viagens_id',
            'pedidos.cpf',
            'pedidos.valor',
            'pedidos.status',
            'pedidos.data_insert',
            'clientes.nome as cliente_nome',
            'viagens.descricao as viagem_descricao'
        ];
        $pedidos->join('clientes', 'clientes.id', '=', 'pedidos.clientes_id');
        $pedidos->join('viagens', 'viagens.id', '=', 'pedidos.viagens_id');
        foreach ($params as $campo => $param) {
            $pedidos->where($campo, '=' , $param);
        }
        $pedidos->where('pedidos.excluido', 'N');

        if(isset($_SESSION['user'])){
            array_push($selectArr, 'favoritos.id as favoritos_id');
            $pedidos->join('favoritos', function($join){

                $join->on("favoritos.item_id", '=', "pedidos.id")
                ->where('favoritos.item', '=', 'pedidos')
                ->where('favoritos.usuario_id', '=', $_SESSION['user']['id']);
            }, null,  null,'left');
        }

        $pedidos->select($selectArr);

        $result = $pedidos->get();
        
        // var_export( DB::getQueryLog());
        // var_dump($params);exit;
        return $result;
    }

}
