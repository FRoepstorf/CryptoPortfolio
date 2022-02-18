<?php

namespace Froepstorf\UnitTest;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\EnvironmentReader */
class EnvironmentReaderTest extends TestCase
{
    public function testCanGetAppEnvironmentFromEnvironment(): void
    {
        $this->assertInstanceOf(AppEnvironment::class, EnvironmentReader::getAppEnvironment());
    }
}
