<?php

namespace Froepstorf\UnitTest\Services;

use Froepstorf\Cryptoportfolio\Domain\Amount;
use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Price;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Domain\SupportedCurrencies;
use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use Froepstorf\Cryptoportfolio\Services\PurchaseService;
use Froepstorf\Cryptoportfolio\Services\UserService;
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
    private const USER_NAME = 'test';

    private PurchaseRepository|MockObject $purchaseRepositoryMock;

    private LoggerInterface|MockObject $loggerMock;

    private UserService|MockObject $userServiceMock;

    private AggregateMoneyFormatter $aggregateMoneyFormatter;

    private Money $money;

    private User $user;

    private Purchase $purchase;

    private PurchaseService $purchaseService;

    protected function setUp(): void
    {
        $this->money = Money::USD(self::FIVE_THOUSAND_CENTS);
        $this->user = new User(self::USER_NAME);
        $this->purchase = new Purchase(
            new CryptoCoin(self::COIN_NAME),
            new Amount(self::AMOUNT),
            new Price($this->money),
            $this->user
        );

        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->userServiceMock = $this->createMock(UserService::class);
        $this->aggregateMoneyFormatter =  new AggregateMoneyFormatter([
        SupportedCurrencies::USD->value => new IntlMoneyFormatter(new \NumberFormatter('de_DE', NumberFormatter::CURRENCY), new ISOCurrencies()),
    ]);
        $this->purchaseRepositoryMock = $this->createMock(PurchaseRepository::class);

        $this->purchaseService = new PurchaseService($this->loggerMock, $this->aggregateMoneyFormatter, $this->purchaseRepositoryMock, $this->userServiceMock);
    }

    public function testCanProcessPurchase(): void
    {
        $fiftyFiveDollarsFormatted = $this->aggregateMoneyFormatter->format($this->money);
        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with(
                sprintf('Starting to process purchase of coin "%s" amount "%s" for "%s" bought by "%s"',
                    self::COIN_NAME,
                self::AMOUNT,
                $fiftyFiveDollarsFormatted,
                self::USER_NAME
                )
            );

        $this->purchaseRepositoryMock->expects($this->once())
            ->method('store')
            ->with($this->purchase);

        $mockedUserId = $this->createMock(UserId::class);
        $this->userServiceMock->expects($this->once())
            ->method('getUserIdFromUser')
            ->with($this->user)
            ->willReturn($mockedUserId);

        $this->purchaseService->processPurchase($this->purchase);
    }
}
