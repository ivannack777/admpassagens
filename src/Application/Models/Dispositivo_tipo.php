<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Dispositivo_tipo extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['nome','descricao','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'dispositivo_tipo';
    

    /**
     * localiza e retorna um dispositivo_tipo pelo campo passado em $params
     * @param array $params
     * @return Dispositivo_tipos
     */
    static public function list(Array $params=[])
    {
        DB::enableQueryLog();
        $dispositivo_tipos = DB::table('dispositivo_tipo');
        $dispositivo_tipos->select('id','nome','descricao');
        foreach($params as $campo => $param){
            $dispositivo_tipos->where($campo, 'like', "%{$param}%");
        }

        $result = $dispositivo_tipos->get();
        var_dump( DB::getQueryLog(), $params);
        return $result;
    }

   

}