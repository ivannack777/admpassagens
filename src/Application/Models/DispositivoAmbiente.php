<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class DispositivoAmbiente extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','usuario_id','ambiente_id','dispositivo_id','nome'];
    public $timestamps = false;
    public $table = 'dispositivo_ambiente';

    /**
     * localiza e retorna um dispositivo_ambiente pelo campo passado em $params
     * @param array $params
     * @return Dispositivos
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $dispositivo_ambientes = DB::table('dispositivo_ambiente');
        $dispositivo_ambientes->select(
            'dispositivo_ambiente.id',
            'dispositivo_ambiente.ambiente_id',
            'dispositivo_ambiente.dispositivo_id',
            'dispositivo_ambiente.nome',
        );
        $result = $dispositivo_ambientes->get();
        // print_r( DB::getQueryLog());  var_dump( $params);exit;
        return $result;
    }   

}