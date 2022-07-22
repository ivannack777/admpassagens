<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Endereco extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['cep','logradouro','numero','complemento','uf','cidade','pais','excluido','excluido_por','data_excluido'];
    public $timestamps = false;
    public $table = 'endereco';

    /**
     * localiza e retorna um endereco pelo campo passado em $params
     * @param array $params
     * @return Enderecos
     */
    static public function list(Array $params=[])
    {
        // DB::enableQueryLog();
        $enderecos = DB::table('endereco');
        $enderecos->select('*');
        foreach($params as $campo => $param){
            $enderecos->where($campo, '=', $param);
        }
        $result = $enderecos->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }

}