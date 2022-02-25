<?php

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\Amount;
use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Price;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Domain\User;
use Froepstorf\Fixtures\AmountProvider;
use Froepstorf\Fixtures\CryptoCoinProvider;
use Froepstorf\Fixtures\PriceProvider;
use Froepstorf\Fixtures\UserProvider;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Domain\Purchase */
class PurchaseTest extends TestCase
{
    private CryptoCoin $cryptoCoin;

    private Amount $amount;

    private Price $price;

    private User $user;

    private Purchase $purchase;

    protected function setUp(): void
    {
        $this->cryptoCoin = CryptoCoinProvider::build();
        $this->amount = AmountProvider::build();
        $this->price = PriceProvider::build();
        $this->user = UserProvider::build();

        $this->purchase = new Purchase($this->cryptoCoin, $this->amount, $this->price, $this->user);
    }

    public function testCanGetCryptoCoin(): void
    {
        $this->assertSame($this->cryptoCoin, $this->purchase->cryptoCoin);
    }

    public function testCanGetAmount(): void
    {
        $this->assertSame($this->amount, $this->purchase->amount);
    }

    public function testCanGetPrice(): void
    {
        $this->assertSame($this->price, $this->purchase->price);
    }

    public function testCanGetUser(): void
    {
        $this->assertSame($this->user, $this->purchase->user);
    }
}
