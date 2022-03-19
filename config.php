<?php
declare(strict_types=1);

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseRequestMapper;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryClientOptionsBuilder;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use Froepstorf\Cryptoportfolio\Middleware\ErrorHandlerMiddleware;
use Froepstorf\Cryptoportfolio\Persistence\Mongo\MongoDatabaseName;
use Froepstorf\Cryptoportfolio\Persistence\Mongo\MongoDsn;
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
use function DI\env;
use function DI\get;

return [
    AppEnvironment::class => function (): AppEnvironment {
        return EnvironmentReader::getAppEnvironment();
    },

    LoggerInterface::class => function (): LoggerInterface {
        $logger =new Logger('main');
        $logger->pushHandler(new StreamHandler('php://stderr'));

        return $logger;
    },

    MongoDsn::class => create()->constructor(env('MONGO_DSN')),

    Client::class => function (MongoDsn $mongoDsn): Client {
        return new Client($mongoDsn->value);
    },

    MongoDatabaseName::class => create()->constructor(env('MONGO_DATABASE_NAME')),

    PurchaseCollection::class => function(Client $mongoClient, MongoDatabaseName $mongoDatabaseName): PurchaseCollection {
        $collection = $mongoClient->selectCollection($mongoDatabaseName->value, 'purchases');

        return new PurchaseCollection($collection);
    },

    PurchaseReader::class => function(): PurchaseReader {
        return new MongoDbPurchaseReader();
    },

    PurchaseWriter::class => function (PurchaseCollection $purchaseCollection): PurchaseWriter {
        return new MongoDbPurchaseWriter($purchaseCollection);
    },

    PurchaseService::class => create()->constructor(
        get(LoggerInterface::class),
        get(AggregateMoneyFormatter::class),
        get(PurchaseRepository::class),
        get(UserService::class)
    ),

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

    UserCollection::class => function(Client $mongoClient, MongoDatabaseName $mongoDatabaseName): UserCollection {
        $collection = $mongoClient->selectCollection($mongoDatabaseName->value, 'users');

        return new UserCollection($collection);
    },

    UserReader::class => function(UserCollection $userCollection): UserReader {
        return new MongoDbUserReader($userCollection);
    },

    UserWriter::class => function(UserCollection $userCollection): UserWriter {
        return new MongoDbUserWriter($userCollection);
    },

    UserRepository::class => create()->constructor(get(UserReader::class), get(UserWriter::class)),

    UserService::class => create()->constructor(get(UserRepository::class)),

    Scope::class => create(Scope::class),

    ErrorHandlerMiddleware::class => create()->constructor(get(ClientInterface::class), get(Scope::class), get(LoggerInterface::class)),

    SentryDsn::class => create()->constructor(env('SENTRY_DSN')),

    ClientInterface::class => function(AppEnvironment $appEnvironment, SentryDsn $sentryDsn): ClientInterface{
        $optionsBuilder = new SentryClientOptionsBuilder(
            $sentryDsn,
            $appEnvironment
        );

        $clientBuilder = new ClientBuilder($optionsBuilder->build());
        $client = $clientBuilder->getClient();
        $hub = new Hub($client);
        SentrySdk::setCurrentHub($hub);

        return $client;
    }
];