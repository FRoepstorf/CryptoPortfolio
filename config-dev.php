<?php

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryClientOptionsBuilder;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Sentry\ClientBuilder;
use Sentry\ClientInterface;
use Sentry\Options;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\Transport\NullTransport;
use Sentry\Transport\TransportFactoryInterface;
use Sentry\Transport\TransportInterface;

return [
    ClientInterface::class => function(AppEnvironment $appEnvironment): ClientInterface {
        $optionsBuilder = new SentryClientOptionsBuilder(
            EnvironmentReader::getSentryDsn(),
            $appEnvironment
        );
        $transportFactory = new class implements TransportFactoryInterface {

            public function create(Options $options): TransportInterface
            {
                return new NullTransport();
            }
        };
        $clientBuilder = new ClientBuilder($optionsBuilder->build());
        $clientBuilder->setTransportFactory($transportFactory);
        $client = $clientBuilder->getClient();
        $hub = new Hub($client);
        SentrySdk::setCurrentHub($hub);

        return $client;
    }
];