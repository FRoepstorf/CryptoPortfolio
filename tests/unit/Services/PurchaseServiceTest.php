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
use Froepstorf\Fixtures\AmountProvider;
use Froepstorf\Fixtures\CryptoCoinProvider;
use Froepstorf\Fixtures\PriceProvider;
use Froepstorf\Fixtures\UserProvider;
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
    private PurchaseRepository|MockObject $purchaseRepositoryMock;

    private LoggerInterface|MockObject $loggerMock;

    private UserService|MockObject $userServiceMock;

    private AggregateMoneyFormatter $aggregateMoneyFormatter;

    private User $user;

    private Purchase $purchase;

    private PurchaseService $purchaseService;

    protected function setUp(): void
    {
        $this->user = UserProvider::build();
        $this->purchase = new Purchase(
            CryptoCoinProvider::build(),
            AmountProvider::build(),
            PriceProvider::build(),
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
        $fiftyFiveDollarsFormatted = $this->aggregateMoneyFormatter->format(PriceProvider::build()->asMoney());
        $this->loggerMock->expects($this->once())
            ->method('info')
            ->with(
                sprintf('Starting to process purchase of coin "%s" amount "%s" for "%s" bought by "%s"',
                    CryptoCoinProvider::COIN_NAME,
                AmountProvider::AMOUNT,
                $fiftyFiveDollarsFormatted,
                UserProvider::USER_NAME
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
