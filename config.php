<?php
declare(strict_types=1);

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

return [
    AppEnvironment::class => function (): AppEnvironment {
        return EnvironmentReader::getAppEnvironment();
    },

    LoggerInterface::class => function (AppEnvironment $appEnvironment): LoggerInterface {
        if ($appEnvironment->isTest()) {
            return new NullLogger();
        }
        $logger =new Logger('main');
        $logger->pushHandler(new StreamHandler('php://stderr'));

        return $logger;
    },

    PurchaseService::class => function (LoggerInterface $logger): PurchaseService {
        return new PurchaseService($logger);
    }
];