<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use DI\Bridge\Slim\Bridge;
use Slim\App;

class AppBuilder
{
    public static function build(ContainerBuilder $containerBuilder): App
    {
        return Bridge::create($containerBuilder->build(EnvironmentReader::getAppEnvironment()));
    }
}