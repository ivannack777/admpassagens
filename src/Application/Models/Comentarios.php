<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Comentarios extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['id','key','item','item_id','usuario_id','texto','excluido','excluido_data','excluido_por'];
    public $timestamps = false;
    public $table = 'comentarios';

    /**
     * localiza e retorna um comentarios pelo campo passado em $params.
     *
     * @return Comentarios
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $comentarios = DB::table('comentarios');
        $comentarios->select(
            'comentarios.id',
            'comentarios.key',
            'comentarios.item',
            'comentarios.item_id',
            'comentarios.usuario_id',
            'comentarios.texto',
            'comentarios.excluido',
            'comentarios.excluido_data',
            'comentarios.excluido_por',
            'comentarios.data_insert', 
            'comentarios.data_update',
            'usuarios.usuario'
        );
        
        if (isset($params['id'])) {
            $comentarios->where('comentarios.id', $params['id']);
        }
        if ( isset($params['item']) && isset($params['item_id']) && isset($params['usuario_id']) ) {
            $comentarios->where('comentarios.item', $params['item']);
            $comentarios->where('comentarios.item_id', $params['item_id']);
            $comentarios->where('comentarios.usuario_id', $params['usuario_id']);
        }
        $comentarios->join('usuarios', 'comentarios.usuario_id','=', 'usuarios.id', 'left');
        $comentarios->where('comentarios.excluido', 'N');
        $comentarios->orderBy('comentarios.data_insert', 'desc');
        $result = $comentarios->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

}
