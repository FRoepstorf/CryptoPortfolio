<?php
declare(strict_types=1);

namespace Froepstorf\UnitTest\Domain;

use Froepstorf\Cryptoportfolio\Domain\Amount;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Domain\Amount */
class AmountTest extends TestCase
{
    private const AMOUNT = 3.5;

    public function testCanGetAmountAsFloat(): void
    {
        $amount = new Amount(self::AMOUNT);

        $this->assertSame(self::AMOUNT, $amount->asFloat());
    }
}
