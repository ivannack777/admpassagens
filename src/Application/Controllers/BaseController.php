<?php

declare(strict_types=1);

namespace App\Application\Controllers;
use Psr\Container\ContainerInterface;

class BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
}
