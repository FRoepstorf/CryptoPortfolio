<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\Price;
use Money\Money;
use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{
    public function testCanGetAsMoney(): void
    {
        $money = Money::USD('500');
        $price = new Price($money);

        $this->assertSame($money, $price->asMoney());
    }
}
