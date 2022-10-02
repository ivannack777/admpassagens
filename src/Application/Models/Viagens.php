<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Viagens extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['veiculos_id', 'descricao', 'origem_id', 'destino_id', 'data_saida', 'data_chegada', 'detalhes','valor','assentos','assentos_tipo'];
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
        // var_dump($_SESSION);exit;
        $viagens = DB::table('viagens');
        $selectArr = [
            'viagens.id',
            'viagens.key',
            'viagens.veiculos_id',
            'viagens.descricao',
            'viagens.origem_id',

            'localidades_origem.localidade as localidade_origem',
            'localidades_origem.nome_municipio as municipio_origem',
            'localidades_origem.nome_distrito as distrito_origem',
            'localidades_origem.nome_uf as nome_uf_origem',
            'localidades_origem.sigla_uf as sigla_uf_origem',
            
            'localidades_destino.localidade as localidade_destino',
            'localidades_destino.nome_municipio as municipio_destino',
            'localidades_destino.nome_distrito as distrito_destino',
            'localidades_destino.nome_uf as nome_uf_destino',
            'localidades_destino.sigla_uf as sigla_uf_destino',
            
            'viagens.destino_id',
            'viagens.data_saida',
            'viagens.data_chegada',
            'viagens.valor',
            'viagens.detalhes',
            'viagens.assentos',
            'viagens.assentos_tipo',
            'veiculos.marca',
            'veiculos.modelo',
            'veiculos.ano',
            'veiculos.codigo',
            'veiculos.placa',
        ];
        
        foreach ($params as $campo => $param) {
            $viagens->where($campo, '=', $param);
        }
        $viagens->join('veiculos', 'veiculos.id', '=', 'viagens.veiculos_id', 'left');
        $viagens->join(DB::raw('ibge_localidades localidades_origem'), 'localidades_origem.id', '=', 'viagens.origem_id', 'left');
        $viagens->join(DB::raw('ibge_localidades localidades_destino'), 'localidades_destino.id', '=', 'viagens.destino_id', 'left');

        if(isset($_SESSION['user'])){
            array_push($selectArr, 'favoritos.id as favoritos_id');
            $viagens->join('favoritos', function($join){

                $join->on("favoritos.item_id", '=', "viagens.id")
                ->where('favoritos.item', '=', 'viagens')
                ->where('favoritos.usuario_id', '=', $_SESSION['user']['id']);
            }, null,  null,'left');
        }

        $viagens->select($selectArr);

        $viagens->where('viagens.excluido', '=', 'N');

        $result = $viagens->get();
        // echo "<pre>";
        // var_export(DB::getQueryLog());
        // var_export($params);
        // echo "</pre>";
        // exit;

        return $result;
    }


}
