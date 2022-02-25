<?php
declare(strict_types=1);

namespace Froepstorf\Fixtures;

use Froepstorf\Cryptoportfolio\Domain\Price;
use Money\Money;

class PriceProvider
{
    public static function build(Money $money = null): Price
    {
        return new Price($money ?? Money::USD(500));
    }
}