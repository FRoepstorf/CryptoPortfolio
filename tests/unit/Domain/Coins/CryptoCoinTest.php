<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Domain\Coins;

use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;
use Froepstorf\Cryptoportfolio\Domain\Coins\SupportedCryptoCoins;
use PHPUnit\Framework\TestCase;

class CryptoCoinTest extends TestCase
{
    public function testCanGetName(): void
    {
        $cryptoCoin = new CryptoCoin(SupportedCryptoCoins::AXS->value);

        $this->assertSame(SupportedCryptoCoins::AXS->value, $cryptoCoin->coinName);
    }
}
