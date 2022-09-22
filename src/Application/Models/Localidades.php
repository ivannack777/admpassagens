<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Localidades extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id', 'uf', 'nome_uf', 'rank','codigo_regiao_geografica_intermediaria', 'nome_regiao_geografica_intermediaria', 'codigo_regiao_geografica_imediata', 'nome_regiao_geografica_imediata', 'codigo_mesorregiao_geografica', 'nome_mesorregiao', 'codigo_microrregiao_geografica', 'nome_microrregiao', 'codigo_municipio', 'codigo_municipio_completo', 'nome_municipio', 'codigo_distrito', 'codigo_de_distrito_completo', 'nome_distrito', 'codigo_categoria', 'categoria'];
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
        $localidades->select(
            'ibge_localidades.id',
            'ibge_localidades.codigo_uf',
            'ibge_localidades.nome_uf',
            'ibge_localidades.rank',
            'ibge_localidades.sigla_uf',
            'ibge_localidades.codigo_municipio_completo',
            'ibge_localidades.nome_municipio',
            'ibge_localidades.codigo_de_distrito_completo',
            'ibge_localidades.nome_distrito',
            'ibge_localidades.codigo_categoria',
            'ibge_localidades.categoria',
            'ibge_localidades.localidade',
            'ibge_localidades.longitude',
            'ibge_localidades.latitude',
            'ibge_localidades.altitude'
        );
        // $localidades->selectRaw("concat(ibge_localidades.localidade,'/',ibge_localidades.nome_municipio, ' - ', ibge_localidades.sigla_uf) as local");
        foreach ($params as $campo => $param) {
            if ($campo == 'ibge_localidades.nome') {
                $localidades->whereRaw("(
                    ibge_localidades.nome_municipio LIKE '{$param}%' collate utf8mb4_general_ci 
                    OR ibge_localidades.nome_distrito LIKE '{$param}%' collate utf8mb4_general_ci 
                    OR ibge_localidades.localidade LIKE '{$param}%' collate utf8mb4_general_ci
                )");
            } else if ($campo == 'ibge_localidades.codigo_categoria') {
                $localidades->whereIn($campo, $param);
            } else {
                $localidades->where($campo, '=' , $param);
            }
        }
        $localidades->orderBy('rank', 'desc');
        $localidades->limit(15);
        $result = $localidades->get();
        
        // var_export( DB::getQueryLog());
        // var_dump($params);exit;
        return $result;
    }
}
