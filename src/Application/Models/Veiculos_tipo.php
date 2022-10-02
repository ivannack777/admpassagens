<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Veiculos_tipo extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'nome', 'descricao'];
    public $timestamps = false;
    public $table = 'veiculos_tipo';

    /**
     * localiza e retorna um veiculos_tipo pelo campo passado em $params.
     *
     * @return Veiculos_tipo
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $veiculos_tipos = DB::table('veiculos_tipo');
        $selectArr = [
            'veiculos_tipo.id',
            'veiculos_tipo.nome',
            'veiculos_tipo.descricao',
        ];
        // $veiculos_tipos->selectRaw("'' as icone");
        // $veiculos_tipos->selectRaw("'' as icone_power");
        foreach ($params as $campo => $param) {
            if ($campo == 'veiculos_tipo.nome') {
                $veiculos_tipos->where($campo, 'like', "%{$param}%");
            } else {
                $veiculos_tipos->where($campo, '=', $param);
            }
        }

        if(isset($_SESSION['user'])){
            array_push($selectArr, 'favoritos.id as favoritos_id');
            $veiculos_tipos->join('favoritos', function($join){

                $join->on("favoritos.item_id", '=', "veiculos_tipo.id")
                ->where('favoritos.item', '=', 'veiculos_tipo')
                ->where('favoritos.usuario_id', '=', $_SESSION['user']['id']);
            }, null,  null,'left');
        }

        $veiculos_tipos->select($selectArr);

        $veiculos_tipos->where('veiculos_tipo.excluido', 'N');
        $result = $veiculos_tipos->get();
        // print_r( DB::getQueryLog());  var_dump( $params);exit;
        return $result;
    }
}
