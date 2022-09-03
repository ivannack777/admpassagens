<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Localidades extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'uf', 'nome_uf', 'codigo_regiao_geografica_intermediaria', 'nome_regiao_geografica_intermediaria', 'codigo_regiao_geografica_imediata', 'nome_regiao_geografica_imediata', 'codigo_mesorregiao_geografica', 'nome_mesorregiao', 'codigo_microrregiao_geografica', 'nome_microrregiao', 'codigo_municipio', 'codigo_municipio_completo', 'nome_municipio', 'codigo_distrito', 'codigo_de_distrito_completo', 'nome_distrito', 'codigo_categoria', 'categoria'];
    public $timestamps = false;
    public $table = 'ibge_localidades';

    /**
     * localiza e retorna um localidade pelo campo passado em $params.
     *
     * @return Enderecos
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $localidades = DB::table('ibge_localidades');
        $localidades->select('id', 'uf', 'nome_uf', 'codigo_regiao_geografica_intermediaria', 'nome_regiao_geografica_intermediaria', 'codigo_regiao_geografica_imediata', 'nome_regiao_geografica_imediata', 'codigo_mesorregiao_geografica', 'nome_mesorregiao', 'codigo_microrregiao_geografica', 'nome_microrregiao', 'codigo_municipio', 'codigo_municipio_completo', 'nome_municipio', 'codigo_distrito', 'codigo_de_distrito_completo', 'nome_distrito', 'codigo_categoria', 'categoria');
        foreach ($params as $campo => $param) {
            if ($campo == 'nome') {
                $localidades->whereRaw("(nome_municipio LIKE '%{$param}%' OR nome_distrito LIKE '%{$param}%')");
            } else if ($campo == 'codigo_categoria') {
                $localidades->whereIn($campo, $param);
            } else {
                $localidades->where($campo, '=' , $param);
            }
        }
        $result = $localidades->get();
        // var_export( DB::getQueryLog());
        // var_dump($params);exit;
        return $result;
    }
}
