<?php

declare(strict_types=1);

namespace App\Application\Controllers;
use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;
use App\Application\Models\ApiCall;


class BaseController
{
    protected $container;
    protected $views;
    protected $session;
    protected $api;
    

    // constructor receives container instance
    public function __construct(ContainerInterface $container=null)
    {
        $this->container = $container;
        $this->views = new PhpRenderer('../src/Application/Views');
        $userSession = $_SESSION['user'] ?? false;
        $this->views->setAttributes(['userSession'=> $userSession] );
        $this->usersession = $userSession;
        $this->api = new ApiCall();
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request
     * @param array $errorsMessage
     * @param string $separator
     * @return string $str
     */
    public function valitorMessages(array $errorsMessage, string $separator='; '): array
    {
        $str = '';
        $arr = [];
        foreach($errorsMessage as $field => $errorMessages){
            $str .= $field .": ";
            
            foreach($errorMessages as $errorMessage){
                $str .= $errorMessage;
                $str .= $separator;
                $arr[$field] = $errorMessage;
            }

        }
        return ['errors'=>$arr, 'msg'=>trim($str)];
    }


    /**
     * Converte dada 
     * @param string $date
     * @return string $format
     */
    public function dateFormat($date, $formatIn='d/m/Y H:i',  $formatOut=null)
    {
        //retirar / repetidas, exeto as // depois do :
        $dt = \DateTime::createFromFormat($formatIn, $date);
        return ($dt instanceof \DateTime) ? $dt->format($formatOut??'Y-m-d H:i:s') : null ;
    }

    public function getUserSession($idx=false){

        $userSession = $_SESSION['user'] ?? false;
        if($userSession){
            return $idx ? $userSession[$idx]??null : $userSession;
        }
        return false;
    }

    /**
     * Ajuntar o array do
     *  $request->getParsedBody() // json e post
     *  com  $request->getQueryParams() //get
     */
    protected function getRequests($request){
        return array_merge((array)$request->getParsedBody(), (array)$request->getQueryParams() );
    }

}
