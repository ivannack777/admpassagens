<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Viagens extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['veiculos_id', 'descricao', 'origem', 'destino', 'data_saida', 'data_chegada', 'detalhes'];
    public $timestamps = false;
    public $table = 'viagens';

    /**
     * localiza e retorna um viagens pelo campo passado em $params.
     *
     * @return Viagens
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $viagens = DB::table('viagens');
        $viagens->select(
            'viagens.id',
            'viagens.key',
            'viagens.veiculos_id',
            'viagens.descricao',
            'viagens.origem',
            'viagens.destino',
            'viagens.data_saida',
            'viagens.data_chegada',
            'viagens.detalhes',
            'veiculos.marca',
            'veiculos.modelo',
            'veiculos.ano',
            'veiculos.codigo',
            'veiculos.placa',
    );
        foreach ($params as $campo => $param) {
            $viagens->where($campo, '=', $param);
        }
        $viagens->join('veiculos', 'veiculos.id', '=', 'viagens.veiculos_id', 'left');
        $viagens->where('viagens.excluido', '=', 'N');

        $result = $viagens->get();
        // var_dump(DB::getQueryLog(), $params);
        // exit;

        return $result;
    }
}
