<?php

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\Amount;
use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Price;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Money\Money;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Domain\Purchase */
class PurchaseTest extends TestCase
{
    private CryptoCoin $cryptoCoin;

    private Amount $amount;

    private Price $price;

    private Purchase $purchase;

    protected function setUp(): void
    {
        $this->cryptoCoin = new CryptoCoin('AXS');
        $this->amount = new Amount(20.5);
        $this->price = new Price(Money::USD(500));

        $this->purchase = new Purchase($this->cryptoCoin, $this->amount, $this->price);
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
}
