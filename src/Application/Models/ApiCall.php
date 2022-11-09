<?php 
namespace App\Application\Models;

use FastRoute\RouteParser\Std;
use stdClass;

class ApiCall
{

    protected $method = 'GET';
    public  $retorno = [];
    public  $session =  null;
    public  $postData = '';
    private $ssl_vhost = 0;
    private $ssl_vpeer = 0;
    private $auth = false;
    private $json = true;
    private $header = [];
    private $url;


    public function __construct($url=null){
        
        $this->url = $_ENV['API_URL'];
        if($url) $this->url = $url;
    }

    public function getValue(){
        return $this->retorno;
    }

    private function setHeader(){
        if($this->json){
           $header[] =  'Content-Type: application/json'; 
           $this->postData = json_encode($this->postData);
        }
        
        $header[] =  'Authorization: Bearer ' . ($_SESSION['user']['token']??null); 
        
        $this->header = $header ?? null;
    }

    private function request($route=null)
    {
        $this->setHeader();   

        $url = preg_replace('/([^:])(\/{2,})/', '$1/', $this->url . $route); //limpar barras duplas
        $ch = curl_init($url);
        $ignoreCert = $_ENV['API_IGNORE_CERTIFICATE'];

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postData);
        curl_setopt($ch, CURLOPT_COOKIESESSION, true );
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'tmpCoockie' );
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'tmpCoockie' );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        if(!empty($this->header)){
         curl_setopt($ch, CURLOPT_HTTPHEADER, $this->header);
        }
        if($ignoreCert){
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        } 

        $result = curl_exec($ch);

        $info = curl_getinfo($ch);

        // var_dump($_ENV['DEBUG']);
        // var_export($this->header);
        // var_export($info);
        // var_export($result);exit;

        if(curl_errno($ch) > 0 || $result === false){
            $info = curl_getinfo($ch);
            $error = ['status' => false, 'error' => true, 'message' => curl_errno($ch) .' '. curl_error($ch) ];
            $this->retorno = json_encode($error);
        }else{
            curl_close($ch); 
            if(!empty($result)) $retorno = json_decode($result);
            // var_dump($retorno);exit;
            if( ($_ENV['DEBUG']??false) && !$retorno || isset($retorno->error)){
                
                echo "<pre>";
                var_export($info['url']);
                var_export($result);
                echo "</pre>";
                exit;
                
            }
            $this->retorno = $retorno;
        }

    }

    public function delete(String $route,  $data,  $json = true, $auth = false){
        $this->method = 'DELETE';
        $this->postData = $data;
        $this->auth = $auth;
        $this->json = $json;
        $this->request($route);
        return $this->retorno;
    }

    public function put(String $route,  $data=[], $json = true, $auth = false){
        $this->method = 'PUT';
        $this->postData = $data;
        $this->auth = $auth;
        $this->json = $json;
        $this->request($route);
        return $this->retorno;
    }

    /**
     * @return Object $retorno
     */
    public function post(String $route,  $data=[],  $json = true, $auth = false){
        $this->method = 'POST';
        $this->postData = $data;
        $this->auth = $auth;
        $this->json = $json;
        $this->request($route);
        return $this->retorno;
    }

    public function get(String $route, $json = true){
        $this->method = 'GET';
        $this->json = $json;
        $this->request($route);
        return $this->retorno;
    }
}
