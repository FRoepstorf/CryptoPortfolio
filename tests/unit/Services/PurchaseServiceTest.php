<?php

namespace Froepstorf\UnitTest\Services;

use Froepstorf\Cryptoportfolio\Domain\Amount;
use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Price;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\AggregateMoneyFormatter;
use Money\Formatter\IntlMoneyFormatter;
use Money\Money;
use NumberFormatter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

/** @covers \Froepstorf\Cryptoportfolio\Services\PurchaseService */
class PurchaseServiceTest extends TestCase
{
    private const COIN_NAME = 'AXS';
    private const AMOUNT = 20.5;
    private const FIVE_THOUSAND_CENTS = 5500;
    private PurchaseRepository|MockObject $purchaseRepositoryMock;

    private LoggerInterface|MockObject $loggerMock;

    private AggregateMoneyFormatter $aggregateMoneyFormatter;

    private Money $money;

    private Purchase $purchase;

    private PurchaseService $purchaseService;

    protected function setUp(): void
    {
        $this->money = Money::USD(self::FIVE_THOUSAND_CENTS);
        $this->purchase = new Purchase(
            new CryptoCoin(self::COIN_NAME),
            new Amount(self::AMOUNT),
            new Price($this->money)
        );

        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->aggregateMoneyFormatter =  new AggregateMoneyFormatter([
        SupportedCurrencies::USD->value => new IntlMoneyFormatter(new \NumberFormatter('de_DE', NumberFormatter::CURRENCY), new ISOCurrencies()),
    ]);
        $this->purchaseRepositoryMock = $this->createMock(PurchaseRepository::class);

        $this->purchaseService = new PurchaseService($this->loggerMock, $this->aggregateMoneyFormatter, $this->purchaseRepositoryMock);
    }

    public function testCanProcessPurchase(): void
    {
        $fiftyFiveDollarsFormatted = $this->aggregateMoneyFormatter->format($this->money);
        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with(
                sprintf('Starting to process purchase of coin "%s" amount "%s" for "%s"',
                    self::COIN_NAME,
                self::AMOUNT,
                $fiftyFiveDollarsFormatted
                )
            );

        $this->purchaseRepositoryMock->expects($this->once())
            ->method('store')
            ->with($this->purchase);

        $this->purchaseService->processPurchase($this->purchase);
    }
}
