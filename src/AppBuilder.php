<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use DI\Bridge\Slim\Bridge;
use Froepstorf\Cryptoportfolio\Controllers\RootController;
use Slim\App;

class AppBuilder
{
    public static function build(ContainerBuilder $containerBuilder): App
    {
        $app = Bridge::create($containerBuilder->build(EnvironmentReader::getAppEnvironment()));

        $app->get('/', [RootController::class, 'root']);

        return $app;
    }
}