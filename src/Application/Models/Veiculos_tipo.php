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
        $veiculos_tipos->select(
            'veiculos_tipo.id',
            'veiculos_tipo.nome',
            'veiculos_tipo.descricao',
        );
        // $veiculos_tipos->selectRaw("'' as icone");
        // $veiculos_tipos->selectRaw("'' as icone_power");
        foreach ($params as $campo => $param) {
            if ($campo == 'veiculos_tipo.nome') {
                $veiculos_tipos->where($campo, 'like', "%{$param}%");
            } else {
                $veiculos_tipos->where($campo, '=', $param);
            }
        }
        $result = $veiculos_tipos->get();

        return $result;
    }
}
