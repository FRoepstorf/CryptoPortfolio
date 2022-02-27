<?php

namespace Froepstorf\UnitTest\ErrorHandling;

use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn */
class SentryDsnTest extends TestCase
{
    public function testCanGetDsn(): void
    {
        $dsn = 'random';
        $sentryDsn = new SentryDsn($dsn);

        $this->assertSame($dsn, $sentryDsn->value);
    }
}
