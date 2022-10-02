<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Favoritos extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','key','item','item_id','usuario_id','excluido','excluido_data','excluido_por'];
    public $timestamps = false;
    public $table = 'favoritos';

    /**
     * localiza e retorna um favoritos pelo campo passado em $params.
     *
     * @return Favoritos
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $favoritos = DB::table('favoritos');
        $favoritos->select('id','key','item','item_id','usuario_id','excluido','excluido_data','excluido_por','data_insert','data_update');
        
        if (isset($params['id'])) {
            $favoritos->where('id', $params['id']);
        }
        if ( isset($params['item']) && isset($params['item_id']) && isset($params['usuario_id']) ) {
            $favoritos->where('item', $params['item']);
            $favoritos->where('item_id', $params['item_id']);
            $favoritos->where('usuario_id', $params['usuario_id']);
        }
        $favoritos->where('favoritos.excluido', 'N');
        $result = $favoritos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

}
