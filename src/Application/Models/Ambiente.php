<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Ambiente extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','usuario_id', 'empreendimento_id', 'nome','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'ambiente';

    /**
     * localiza e retorna um ambiente pelo campo passado em $params
     * @param array $params
     * @return Ambientes
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $ambientes = DB::table('ambiente');
        $ambientes->select('id','usuario_id', 'empreendimento_id', 'nome');
        foreach($params as $campo => $param){
            if($campo == 'nome'){
                $ambientes->where($campo, 'like', "%{$param}%");
            }else{
                $ambientes->where($campo, '=', $param);
            }
        }
        $result = $ambientes->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

   

}