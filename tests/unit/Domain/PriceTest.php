<?php

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\Price;
use Money\Money;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Domain\Price */
class PriceTest extends TestCase
{
    public function testCanGetAsMoney(): void
    {
        $money = Money::USD('500');
        $price = new Price($money);

        $this->assertSame($money, $price->asMoney());
    }
}
