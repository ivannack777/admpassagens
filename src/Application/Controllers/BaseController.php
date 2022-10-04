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
        $this->views = new PhpRenderer('../Views');
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
    public function dateFormat($date, $format='d/m/Y H:i')
    {
        //retirar / repetidas, exeto as // depois do :
        $dt = \DateTime::createFromFormat($format,$date);
        return ($dt instanceof \DateTime) ? $dt->format('Y-m-d H:i:s') : null ;
        
        return $dt;
    }

    public function getUserSession($idx=false){

        $userSession = $_SESSION['user'] ?? false;
        if($userSession){
            return $idx ? $userSession[$idx]??null : $userSession;
        }
        return false;
    }

}
