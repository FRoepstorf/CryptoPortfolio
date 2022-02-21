<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use DI\Bridge\Slim\Bridge;
use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseController;
use Slim\App;

class AppBuilder
{
    public static function build(ContainerBuilder $containerBuilder): App
    {
        $app = Bridge::create($containerBuilder->build(EnvironmentReader::getAppEnvironment()));

        $app->addBodyParsingMiddleware();

        $app->post('/purchase', [PurchaseController::class, 'registerPurchase']);

        return $app;
    }
}