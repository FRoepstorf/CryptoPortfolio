<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain\Coins;

final class CryptoCoin
{
    public function __construct(
        public readonly string $coinName
    ) {
    }
}
