<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;
use App\Application\Models\Usuarios;

class ListUsers extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = [1,2,3,4];

        $usuarios = Usuarios::get();
        
        var_dump($usuarios->count());
        foreach ($usuarios as $usuario){
            var_dump($usuario->nome);
        }
        
        exit;

        //$this->logger->info("Users list was viewed.");

        return $this->respondWithData($users);
    }
}
