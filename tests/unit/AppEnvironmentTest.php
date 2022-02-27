<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\AppEnvironment */
class AppEnvironmentTest extends TestCase
{
    public function testIsProdReturnsTrueIfProd(): void
    {
        $this->assertTrue(AppEnvironment::PROD->isProd());
    }

    public function testReturnsTrueIfTest(): void
    {
        $this->assertTrue(AppEnvironment::TEST->isTest());
    }

    public function testReturnsFalseIfSetToProd(): void
    {
        $this->assertFalse(AppEnvironment::PROD->isTestOrDev());
    }

    /**
     * @dataProvider nonProdEnvProvider
     */
    public function testReturnsTrueIfDevOrTest(AppEnvironment $appEnvironment): void
    {
        $this->assertTrue($appEnvironment->isTestOrDev());
    }

    /**
     * @dataProvider nonProdEnvProvider()
     */
    public function testIsFalseIfNotSetToProd(AppEnvironment $appEnvironment): void
    {
        $this->assertFalse($appEnvironment->isProd());
    }

    /**
     * @dataProvider nonTestEnvProvider()
     */
    public function testIsFalseIfNotSetToTest(AppEnvironment $appEnvironment): void
    {
        $this->assertFalse($appEnvironment->isTest());
    }

    public function nonProdEnvProvider(): \Iterator
    {
        yield [AppEnvironment::TEST];
        yield [AppEnvironment::DEV];
    }

    public function nonTestEnvProvider(): \Iterator
    {
        yield [AppEnvironment::PROD];
        yield [AppEnvironment::DEV];
    }
}
