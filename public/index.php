<?php

declare(strict_types=1);

use App\Application\Handlers\HttpErrorHandler;
use App\Application\Handlers\ShutdownHandler;
use App\Application\ResponseEmitter\ResponseEmitter;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Slim\Factory\AppFactory;
use Slim\Factory\ServerRequestCreatorFactory;
use Valitron\Validator;
use Psr\Log\LoggerInterface;
use Slim\Http\ServerRequest;

require __DIR__.'/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new ContainerBuilder();

if (false) { // Should be set to true in production
    $containerBuilder->enableCompilation(__DIR__.'/../var/cache');
}

// Set up settings
$settings = require __DIR__.'/../app/settings.php';
$settings($containerBuilder);

// Set up dependencies
$dependencies = require __DIR__.'/../app/dependencies.php';
$dependencies($containerBuilder);

// Set up repositories
$repositories = require __DIR__.'/../app/repositories.php';
$repositories($containerBuilder);

// Build PHP-DI Container instance
$container = $containerBuilder->build();

// Instantiate the app
AppFactory::setContainer($container);
$app = AppFactory::create();
$callableResolver = $app->getCallableResolver();

// Register middleware
$middleware = require __DIR__.'/../app/middleware.php';
$middleware($app);

// Create Request object from globals
$serverRequestCreator = ServerRequestCreatorFactory::create();
$request = $serverRequestCreator->createServerRequestFromGlobals();

// Register routes
$routes = require __DIR__.'/../app/routes.php';
$routes($app, $request);

// definindo linguagem do validador
Validator::lang('pt-br');

/** @var SettingsInterface $settings */
$settings = $container->get(SettingsInterface::class);

// Adicionado para rodar elloquent
$dbSettings = $settings->get('db');
$capsule = new Illuminate\Database\Capsule\Manager();
$capsule->addConnection($dbSettings);
$capsule->bootEloquent();
$capsule->setAsGlobal();

$displayErrorDetails = $settings->get('displayErrorDetails');
$logError = $settings->get('logError');
$logErrorDetails = $settings->get('logErrorDetails');

// Create Error Handler
$responseFactory = $app->getResponseFactory();
$errorHandler = new HttpErrorHandler($callableResolver, $responseFactory);

// Create Shutdown Handler
$shutdownHandler = new ShutdownHandler($request, $errorHandler, $displayErrorDetails);
register_shutdown_function($shutdownHandler);

// Add Routing Middleware
$app->addRoutingMiddleware();

// Add Body Parsing Middleware
$app->addBodyParsingMiddleware();

// Add Error Middleware
// comentado para exibir erro padrão
// Define Custom Error Handler
$customErrorHandler = function (
    ServerRequest $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    // $logger->error($exception->getMessage());

    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT)
    );

    return $response;
};

// Add Error Middleware
// $errorMiddleware = $app->addErrorMiddleware(true, true, true);
// $errorMiddleware->setDefaultErrorHandler($customErrorHandler);
// Run App & Emit Response
$response = $app->handle($request);
$responseEmitter = new ResponseEmitter();
$responseEmitter->emit($response);

// $app->run();