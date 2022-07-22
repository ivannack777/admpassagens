<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Empreendimento extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['usuario_id','endereco_id','nome','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'empreendimento';

    /**
     * localiza e retorna um empreendimento pelo campo passado em $params
     * @param array $params
     * @return Empreendimentos
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $empreendimentos = DB::table('empreendimento');
        $empreendimentos->select('*');
        foreach($params as $campo => $param){
            $empreendimentos->where($campo, '=', $param);
        }
        $result = $empreendimentos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

}