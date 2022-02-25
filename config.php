<?php
declare(strict_types=1);

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseRequestMapper;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryClientOptionsBuilder;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use Froepstorf\Cryptoportfolio\Middleware\ErrorHandlerMiddleware;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection\PurchaseCollection;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseReader;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseWriter;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseReader;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseWriter;
use Froepstorf\Cryptoportfolio\Persistence\User\Collection\UserCollection;
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
use function DI\create;

return [
    AppEnvironment::class => function (): AppEnvironment {
        return EnvironmentReader::getAppEnvironment();
    },

    LoggerInterface::class => function (): LoggerInterface {
        $logger =new Logger('main');
        $logger->pushHandler(new StreamHandler('php://stderr'));

        return $logger;
    },

    Client::class => function (): Client {
        return new Client(EnvironmentReader::getMongoDsn());
    },

    PurchaseCollection::class => function(Client $mongoClient): PurchaseCollection {
        $collection = $mongoClient->selectCollection(EnvironmentReader::getMongoDatabaseName(), 'purchases');

        return new PurchaseCollection($collection);
    },

    PurchaseReader::class => function(PurchaseCollection $purchaseCollection): PurchaseReader {
        return new MongoDbPurchaseReader($purchaseCollection);
    },

    PurchaseWriter::class => function (PurchaseCollection $purchaseCollection): PurchaseWriter {
        return new MongoDbPurchaseWriter($purchaseCollection);
    },

    PurchaseService::class => function (
        LoggerInterface $logger,
        AggregateMoneyFormatter $moneyFormatter,
        PurchaseRepository $purchaseRepository,
        UserService $userService
    ): PurchaseService {
        return new PurchaseService($logger, $moneyFormatter, $purchaseRepository, $userService);
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

    UserCollection::class => function(Client $mongoClient): UserCollection {
        $collection = $mongoClient->selectCollection(EnvironmentReader::getMongoDatabaseName(), 'users');

        return new UserCollection($collection);
    },

    UserReader::class => function(UserCollection $userCollection): UserReader {
        return new MongoDbUserReader($userCollection);
    },

    UserWriter::class => function(UserCollection $userCollection): UserWriter {
        return new MongoDbUserWriter($userCollection);
    },

    UserRepository::class => function(UserReader $userReader, UserWriter $userWriter): UserRepository {
        return new UserRepository($userReader, $userWriter);
    },

    UserService::class => function(UserRepository $userRepository): UserService {
        return new UserService($userRepository);
    },

    Scope::class => create(Scope::class),

    ErrorHandlerMiddleware::class => function(
        ClientInterface $client,
        Scope $scope,
        LoggerInterface $logger,
        AppEnvironment $appEnvironment
    ): ErrorHandlerMiddleware {
        return new ErrorHandlerMiddleware($client, $scope, $logger, $appEnvironment);
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