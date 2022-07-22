<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Cena extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','usuario_id','nome','configuracoes','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'cena';

    /**
     * localiza e retorna um cena pelo campo passado em $params
     * @param array $params
     * @return Cenas
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $cenas = DB::table('cena');
        $cenas->select('*');
        foreach($params as $campo => $param){
            $cenas->where($campo, '=', $param);
        }
        $result = $cenas->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }


}