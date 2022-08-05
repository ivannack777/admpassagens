<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Dispositivo extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','dispositivo_tipo_id','empreendimento_id','usuario_id','ambiente_id','nome','marca','modelo','icone', 'estado'];
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
            'ambiente.nome as ambiente',
            'dispositivo.nome',
            'dispositivo.marca',
            'dispositivo.modelo',
            'dispositivo.estado',
            'dispositivo.favorito',
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
        // print_r( DB::getQueryLog());
        // var_dump( $params);exit;
        return $result;
    }   

}