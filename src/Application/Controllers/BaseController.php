<?php

declare(strict_types=1);

namespace App\Application\Controllers;
use Psr\Container\ContainerInterface;
use Slim\Views\PhpRenderer;

class BaseController
{
    protected $container;
    protected $views;
    protected $session;
    
    

    // constructor receives container instance
    public function __construct(ContainerInterface $container=null)
    {
        $this->container = $container;
        $this->views = new PhpRenderer('../Views');
        $session = $_SESSION['admpassagens'] ?? false;
        $this->views->setAttributes(['session'=> $session] );
        $this->usersession = $session;
    }

    /**
     * Localiza e retorna um enderecos passando 'endereco' por json request
     * @param array $errorsMessage
     * @param string $separator
     * @return string $str
     */
    public function valitorMessages(array $errorsMessage, string $separator='; '): string
    {
        $str = '';
        foreach($errorsMessage as $field => $errorMessages){
            $str .= $field .": ";
            foreach($errorMessages as $errorMessage){
                $str .= $errorMessage;
                $str .= $separator;
            }

        }
        return trim($str);
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
        return $dt->format('Y-m-d H:i:s') ;
        
        return $dt;
    }

    public function getUserSession($idx=false){
        $userSession = $_SESSION['admpassagens']['user'] ?? false;
        if($userSession){
            return $idx ? $userSession[$idx]??null : $userSession;
        }
        return false;
    }

}
