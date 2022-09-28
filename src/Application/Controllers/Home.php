<?php

declare(strict_types=1);

namespace App\Application\Controllers;

use App\Application\Helpers\Sanitize;
use App\Application\Models\Clientes as ClientesModel;
// use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Http\Response as Response;
use Valitron\Validator;

class Home extends BaseController
{
    protected $container;

    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    /**
     * Localiza e retorna um clientes passando 'clientes' por json request.
     *
     * @return string json
     */
    public function index(Request $request, Response $response)
    {
        $requests = $request->getParsedBody();
        $dados = [];
        if ($this->getUserSession()) {
            $this->views->render($response, 'header.php', $dados);
            $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'index.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
        }
        else{
            $this->views->render($response, 'header.php', $dados);
            // $this->views->render($response, 'left.php', $dados);
            $this->views->render($response, 'right_top.php', $dados);
            $this->views->render($response, 'index.php', $dados);
            return $this->views->render($response, 'footer.php', $dados);
            
        }
    }

}
