<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;

final class Purchase
{
    public function __construct(
        public readonly CryptoCoin $cryptoCoin,
        public readonly Amount $amount,
        public readonly Price $price
    )
    {
    }
}