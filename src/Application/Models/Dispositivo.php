<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Dispositivo extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','dispositivo_tipo_id','usuario_id','nome','marca','modelo'];
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
        $dispositivos->select('id','dispositivo_tipo_id','usuario_id','nome','marca','modelo');
        foreach($params as $campo => $param){
            if($campo == 'nome'){
                $dispositivos->where($campo, 'like', "%{$param}%");
            } else{
                $dispositivos->where($campo, '=', $param);
            }
        }
        $result = $dispositivos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }   

}