<?php

namespace App\Application\Models;

use Illuminate\Database\Capsule\Manager as DB;

class Empresas extends \Illuminate\Database\Eloquent\Model
{
    protected $fillable = ['usuarios_id', 'enderecos_id', 'nome'];
    public $timestamps = false;
    public $table = 'empresas';

    /**
     * localiza e retorna um empresas pelo campo passado em $params.
     *
     * @return Empresas
     */
    public static function list(array $params = [])
    {
        // DB::enableQueryLog();
        $empresas = DB::table('empresas');
        $selectArr = ['empresas.id', 'empresas.usuarios_id', 'empresas.enderecos_id', 'empresas.nome', 'empresas.cnpj', 'empresas.cep', 'empresas.logradouro', 'empresas.numero', 'empresas.bairro', 'empresas.uf', 'empresas.cidade'];
        foreach ($params as $campo => $param) {
            if ($campo == 'nome') {
                $empresas->where($campo, 'like', "%{$param}%");
            } else {
                $empresas->where($campo, '=', $param);
            }
        }

        if(isset($_SESSION['user'])){
            array_push($selectArr, 'favoritos.id as favoritos_id');
            $empresas->join('favoritos', function($join){

                $join->on("favoritos.item_id", '=', "empresas.id")
                ->where('favoritos.item', '=', 'empresas')
                ->where('favoritos.usuario_id', '=', $_SESSION['user']['id']);
            }, null,  null,'left');
        }

        $empresas->select($selectArr);

        $empresas->where('empresas.excluido', 'N');
        $result = $empresas->get();
        // var_dump( DB::getQueryLog(), $params);exit;
        return $result;
    }
}
