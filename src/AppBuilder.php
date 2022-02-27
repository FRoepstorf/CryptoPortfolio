<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use DI\Bridge\Slim\Bridge;
use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseController;
use Froepstorf\Cryptoportfolio\Controllers\User\UserController;
use Froepstorf\Cryptoportfolio\Middleware\ErrorHandlerMiddleware;
use Slim\App;

class AppBuilder
{
    public static function build(ContainerBuilder $containerBuilder): App
    {
        $container = $containerBuilder->build(EnvironmentReader::getAppEnvironment());
        $app = Bridge::create($container);

        $app->addBodyParsingMiddleware();

        $app->addMiddleware($container->get(ErrorHandlerMiddleware::class));

        $app->post('/purchase', [PurchaseController::class, 'registerPurchase']);
        $app->post('/user', [UserController::class, 'create']);

        return $app;
    }
}