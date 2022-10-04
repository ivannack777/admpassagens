<?php namespace App\Models;

use CodeIgniter\Model;

class Apirequest extends Model
{

    protected $method = 'GET';
    public $retorno = false;

    public function getValue(){
        return $this->retorno;
    }
    protected function request(String $url, Array $data=[]){
        $client = \Config\Services::curlrequest();
        $reposta = $client->request($this->method, $url, [
            'form_params' => $data,
            'http_errors' => false
            ]);
            if($reposta &&  method_exists($reposta, 'getBody') ){
                $this->retorno = $reposta->getBody();
            } 

    }

    public function post(String $url, Array $data=[]){
        $this->method = 'POST';
        $this->request($url, $data);
    }


    public function get(String $url, Array $data=[]){
        $this->method = 'GET';
        $this->request($url, $data);
    }
}
