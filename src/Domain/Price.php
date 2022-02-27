<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

use Money\Money;

final class Price
{
    public function __construct(private readonly Money $money)
    {
    }

    public function asMoney(): Money
    {
        return $this->money;
    }
}