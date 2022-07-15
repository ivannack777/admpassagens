<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Dispositivo extends \Illuminate\Database\Eloquent\Model
{
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
        $dispositivos->select('*');
        foreach($params as $campo => $param){
            $dispositivos->where($campo, '=', $param);
        }
        $result = $dispositivos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }


 /**
     * localiza e retorna um dispositivo pelo campo passado em $params
     * @param array $params
     * @return Dispositivos
     */
    static public function tipo_list(Array $params=[])
    {
        // DB::enableQueryLog();
        $dispositivos = DB::table('dispositivo_tipo');
        $dispositivos->select('*');
        foreach($params as $campo => $param){
            $dispositivos->where($campo, '=', $param);
        }
        $result = $dispositivos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

   

}