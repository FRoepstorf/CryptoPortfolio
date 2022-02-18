<?php
declare(strict_types=1);

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Monolog\Handler\StreamHandler;

return [
    AppEnvironment::class => function () {
        return EnvironmentReader::getAppEnvironment();
    },

    \Psr\Log\LoggerInterface::class => function (AppEnvironment $appEnvironment) {
        if ($appEnvironment->isTest()) {
            return new \Psr\Log\NullLogger();
        }
        $logger =new \Monolog\Logger('main');
        $logger->pushHandler(new StreamHandler('php://stderr'));

        return $logger;
    }
];