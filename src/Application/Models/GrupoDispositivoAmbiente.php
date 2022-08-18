<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class GrupoDispositivoAmbiente extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','usuario_id','ambiente_id','nome'];
    public $timestamps = false;
    public $table = 'grupo_dispositivo_ambiente';

    /**
     * localiza e retorna um grupo_dispositivo_ambiente pelo campo passado em $params
     * @param array $params
     * @return Dispositivos
     */
    static public function list(Array $params=[])
    {
        DB::enableQueryLog();
        $grupo_dispositivo_ambientes = DB::table('grupo_dispositivo_ambiente');
        $grupo_dispositivo_ambientes->select(
            'grupo_dispositivo_ambiente.id',
            'grupo_dispositivo_ambiente.ambiente_id',
            'grupo_dispositivo_ambiente.dispositivo_tipo_id',
            'grupo_dispositivo_ambiente.nome',
            'grupo_dispositivo_ambiente.estado',
            'dispositivo_tipo.nome as tipo_dispositivo',
            'ambiente.nome as ambiente_nome',
        );
        $grupo_dispositivo_ambientes->join('ambiente', 'ambiente.id','=','grupo_dispositivo_ambiente.ambiente_id', 'left');
        $grupo_dispositivo_ambientes->join('dispositivo_tipo', 'dispositivo_tipo.id','=','grupo_dispositivo_ambiente.dispositivo_tipo_id', 'left');
        foreach($params as $campo => $param){
            if($campo == 'dispositivo.nome'){
                $grupo_dispositivo_ambientes->where($campo, 'like', "%{$param}%");
            } else{
                $grupo_dispositivo_ambientes->where($campo, '=', $param);
            }
        }
        $result = $grupo_dispositivo_ambientes->get();
        // print_r( DB::getQueryLog());  var_dump( $params);exit;
        return $result;
    }   

}