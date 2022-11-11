<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    $dotenv = Dotenv\Dotenv::createMutable(__DIR__);
    $dotenv->load();

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            // var_dump($_ENV['DB_HOST']);exit;
            return new Settings([
                'displayErrorDetails' => $_ENV['DISPLAYERRORDETAILS'], // Should be set to false in production
                'logError'            => $_ENV['LOGERROR'],
                'logErrorDetails'     => $_ENV['LOGERRORDETAILS'],
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../log/app.log',
                    'level' => Logger::DEBUG,
                ],
                "db" => [
                    'driver' => 'mysql',
                    'host' =>  $_ENV['DB_HOST'],
                    'database' => $_ENV['DB_NAME'],
                    'username' =>  $_ENV['DB_USER'],
                    'password' =>  $_ENV['DB_PASSWORD'],
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'prefix' => '',
                ]
            ]);
        }
    ]);
};
