<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Dispositivo extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','dispositivo_tipo_id','empreendimento_id','usuario_id','ambiente_id','grupo_dispositivo_ambiente_id','nome','marca','modelo','icone', 'estado','propriedades','configuracoes'];
    public $timestamps = false;
    public $table = 'dispositivo';

    /**
     * localiza e retorna um dispositivo pelo campo passado em $params
     * @param array $params
     * @return Dispositivos
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $dispositivos = DB::table('dispositivo');
        $dispositivos->select(
            'dispositivo.id',
            'dispositivo.dispositivo_tipo_id',
            'dispositivo.usuario_id',
            'dispositivo.ambiente_id',
            'dispositivo.grupo_dispositivo_ambiente_id',
            'ambiente.nome as ambiente',
            'dispositivo.nome',
            'dispositivo.marca',
            'dispositivo.modelo',
            'dispositivo.estado',
            'dispositivo.favorito',
            'dispositivo.propriedades',
            'dispositivo.configuracoes',
            'dispositivo_tipo.icone_on',
            'dispositivo_tipo.icone_off',
            'dispositivo_tipo.icone_power_on',
            'dispositivo_tipo.icone_power_off',
            'dispositivo_tipo.nome as dispositivo_tipo',
            'dispositivo_tipo.botao_tipo'
        );
        // $dispositivos->selectRaw("'' as icone");
        // $dispositivos->selectRaw("'' as icone_power");
        foreach($params as $campo => $param){
            if($campo == 'dispositivo.nome'){
                $dispositivos->where($campo, 'like', "%{$param}%");
            } else{
                $dispositivos->where($campo, '=', $param);
            }
        }
        $dispositivos->join('dispositivo_tipo', 'dispositivo.dispositivo_tipo_id', '=', 'dispositivo_tipo.id', 'left');
        $dispositivos->join('ambiente', 'dispositivo.ambiente_id', '=', 'ambiente.id', 'left');
        $result = $dispositivos->get();
        // print_r( DB::getQueryLog());  var_dump( $params);exit;
        if($result->count()){
            foreach($result as $dispositivo){

                //retornar como objeto json
                $dispositivo->propriedades = $dispositivo->propriedades ? json_decode($dispositivo->propriedades) : null;
                $dispositivo->configuracoes = $dispositivo->configuracoes ? json_decode($dispositivo->configuracoes) : null;
                
                // Por padrão, icone e icone_power fica como off 
                $dispositivo->icone = $dispositivo->icone_off;
                $dispositivo->icone_power = $dispositivo->icone_power_off;
                // se o estado == ligado (1), icone e icone_power fica como on
                if($dispositivo->estado){
                    $dispositivo->icone = $dispositivo->icone_on;
                    $dispositivo->icone_power = $dispositivo->icone_power_on;
                }
                // retirar icones on e off, pois já foram substituidos acima
                unset($dispositivo->icone_on);
                unset($dispositivo->icone_off);
                unset($dispositivo->icone_power_on);
                unset($dispositivo->icone_power_off);

                //forçar icone = null temporariamente
                $dispositivo->icone = null;
                $dispositivo->icone_power = null;

            }
        }
        return $result;
    }   

}