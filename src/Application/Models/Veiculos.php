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
        $veiculoss = DB::table('veiculos');
        $veiculoss->select(
            'veiculos.id',
            'veiculos.veiculos_tipo_id',
            'veiculos.marca',
            'veiculos.modelo',
            'veiculos.ano',
            'veiculos.codigo',
            'veiculos.placa',
        );
        // $veiculoss->selectRaw("'' as icone");
        // $veiculoss->selectRaw("'' as icone_power");
        foreach ($params as $campo => $param) {
            $veiculoss->where($campo, '=', $param);
        }
        $veiculoss->join('veiculos_tipo', 'veiculos.veiculos_tipo_id', '=', 'veiculos_tipo.id', 'left');
        $result = $veiculoss->get();
        // print_r( DB::getQueryLog());  var_dump( $params);exit;

        return $result;
    }
}
