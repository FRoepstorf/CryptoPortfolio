<?php
declare(strict_types=1);

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\CryptoCoin;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Domain\CryptoCoin */
class CryptoCoinTest extends TestCase
{
    private const COIN_NAME = 'AXS';

    public function testCanGetName(): void
    {
        $cryptoCoin = new CryptoCoin(self::COIN_NAME);

        $this->assertSame(self::COIN_NAME, $cryptoCoin->getName());
    }
}
