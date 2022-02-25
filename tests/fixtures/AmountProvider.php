<?php
declare(strict_types=1);

namespace Froepstorf\Fixtures;

use Froepstorf\Cryptoportfolio\Domain\Amount;

class AmountProvider
{
    public const AMOUNT = 20.5;

    public static function build(float $value = self::AMOUNT): Amount
    {
        return new Amount($value);
    }
}