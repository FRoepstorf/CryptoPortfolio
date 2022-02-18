<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;

final class Purchase
{
    public function __construct(
        private CryptoCoin $cryptoCoin,
        private Amount $amount,
        private Price $price
    )
    {
    }

    public function getCryptoCoin(): CryptoCoin
    {
        return $this->cryptoCoin;
    }

    public function getAmount(): Amount
    {
        return $this->amount;
    }

    public function getPrice(): Price
    {
        return $this->price;
    }
}