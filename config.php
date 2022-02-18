<?php
declare(strict_types=1);

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\AggregateMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
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

    PurchaseService::class => function (LoggerInterface $logger, AggregateMoneyFormatter $moneyFormatter): PurchaseService {
        return new PurchaseService($logger, $moneyFormatter);
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
    }
];