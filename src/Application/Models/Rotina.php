<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Rotina extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','usuario_id', 'nome', 'horarios', 'datas', 'repeticao_tipo', 'repeticao','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'rotina';

    /**
     * localiza e retorna um rotina pelo campo passado em $params
     * @param array $params
     * @return Rotinas
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $rotinas = DB::table('rotina');
        $rotinas->select('*');
        foreach($params as $campo => $param){
            if($campo == 'nome'){
                $rotinas->where($campo, 'like', "%{$param}%");
            }else{
                $rotinas->where($campo, '=', $param);
            }
        }
        $result = $rotinas->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

   

}