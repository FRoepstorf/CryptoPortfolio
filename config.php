<?php
declare(strict_types=1);

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseRequestMapper;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryClientOptionsBuilder;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use Froepstorf\Cryptoportfolio\Middleware\ErrorHandlerMiddleware;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseReader;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseWriter;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseReader;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseWriter;
use Froepstorf\Cryptoportfolio\Persistence\User\MongoDbUserReader;
use Froepstorf\Cryptoportfolio\Persistence\User\MongoDbUserWriter;
use Froepstorf\Cryptoportfolio\Persistence\User\UserReader;
use Froepstorf\Cryptoportfolio\Persistence\User\UserRepository;
use Froepstorf\Cryptoportfolio\Persistence\User\UserWriter;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use Froepstorf\Cryptoportfolio\Services\UserService;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\AggregateMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use MongoDB\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Sentry\ClientBuilder;
use Sentry\ClientInterface;
use Sentry\SentrySdk;
use Sentry\State\Hub;
use Sentry\State\Scope;

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

    Client::class => function (): Client {
        return new Client(EnvironmentReader::getMongoDsn());
    },

    PurchaseReader::class => function(Client $mongoClient): PurchaseReader {
        return new MongoDbPurchaseReader($mongoClient);
    },

    PurchaseWriter::class => function (Client $mongoClient): PurchaseWriter {
        return new MongoDbPurchaseWriter($mongoClient);
    },

    PurchaseService::class => function (
        LoggerInterface $logger,
        AggregateMoneyFormatter $moneyFormatter,
        PurchaseRepository $purchaseRepository
    ): PurchaseService {
        return new PurchaseService($logger, $moneyFormatter, $purchaseRepository);
    },

    NumberFormatter::class => function(): NumberFormatter {
        return new NumberFormatter('de_DE', NumberFormatter::CURRENCY);
    },

    IntlMoneyFormatter::class => function (NumberFormatter $numberFormatter): IntlMoneyFormatter {
        return new IntlMoneyFormatter($numberFormatter, new ISOCurrencies());
    },

    AggregateMoneyFormatter::class => function (IntlMoneyFormatter $intlMoneyFormatter): AggregateMoneyFormatter {
        return new AggregateMoneyFormatter([
            SupportedCurrencies::USD->value => $intlMoneyFormatter,
            SupportedCurrencies::EUR->value => $intlMoneyFormatter
        ]);
    },

    UserReader::class => function(Client $client): UserReader {
        return new MongoDbUserReader($client);
    },

    UserWriter::class => function(Client $client): UserWriter {
        return new MongoDbUserWriter($client);
    },

    UserRepository::class => function(UserReader $userReader, UserWriter $userWriter): UserRepository {
        return new UserRepository($userReader, $userWriter);
    },

    UserService::class => function(UserRepository $userRepository): UserService {
        return new UserService($userRepository);
    },

    Scope::class => \DI\create(Scope::class),

    ErrorHandlerMiddleware::class => function(
        ClientInterface $client,
        Scope $scope,
        LoggerInterface $logger
    ): ErrorHandlerMiddleware {
        return new ErrorHandlerMiddleware($client, $scope, $logger);
    },

    ClientInterface::class => function(AppEnvironment $appEnvironment): ClientInterface{
        $optionsBuilder = new SentryClientOptionsBuilder(
            new SentryDsn(EnvironmentReader::getSentryDsn()),
            $appEnvironment
        );

        $clientBuilder = new ClientBuilder($optionsBuilder->build());
        $client = $clientBuilder->getClient();
        $hub = new Hub($client);
        SentrySdk::setCurrentHub($hub);

        return $client;
    }
];