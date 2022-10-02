<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Veiculos extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'veiculos_tipo_id', 'empresas_id', 'marca', 'modelo', 'ano', 'codigo', 'placa'];
    public $timestamps = false;
    public $table = 'veiculos';

    /**
     * localiza e retorna um veiculos pelo campo passado em $params.
     *
     * @return Veiculoss
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $veiculos = DB::table('veiculos');
        $selectArr = [
            'veiculos.id',
            'veiculos.empresas_id',
            'veiculos.veiculos_tipo_id',
            'veiculos.marca',
            'veiculos.modelo',
            'veiculos.ano',
            'veiculos.codigo',
            'veiculos.placa',
            'veiculos_tipo.nome as tipo_nome',
            'veiculos_tipo.descricao as tipo_descricao',
            'empresas.nome as empresa',
        ];
        // $veiculos->selectRaw("'' as icone");
        // $veiculos->selectRaw("'' as icone_power");
        foreach ($params as $campo => $param) {
            $veiculos->where($campo, '=', $param);
        }

        $veiculos->join('veiculos_tipo', 'veiculos.veiculos_tipo_id', '=', 'veiculos_tipo.id', 'left');
        $veiculos->join('empresas', 'veiculos.empresas_id', '=', 'empresas.id', 'left');

        if(isset($_SESSION['user'])){
            array_push($selectArr, 'favoritos.id as favoritos_id');
            $veiculos->join('favoritos', function($join){

                $join->on("favoritos.item_id", '=', "veiculos.id")
                ->where('favoritos.item', '=', 'veiculos')
                ->where('favoritos.usuario_id', '=', $_SESSION['user']['id']);
            }, null,  null,'left');
        }

        $veiculos->select($selectArr);

        $veiculos->where('veiculos.excluido', 'N');
        $result = $veiculos->get();
        // print_r( DB::getQueryLog());  var_dump( $params);exit;

        return $result;
    }
}
