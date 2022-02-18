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
        $appEnvironment = AppEnvironment::from('prod');

        $this->assertTrue($appEnvironment->isProd());
    }

    public function testReturnsTrueIfTest(): void
    {
        $appEnvironment = AppEnvironment::from('test');

        $this->assertTrue($appEnvironment->isTest());
    }

    /** @dataProvider nonProdEnvProvider  */
    public function testIsFalseIfNotSetToProd(AppEnvironment $appEnvironment): void
    {
        $this->assertFalse($appEnvironment->isProd());
    }

    /** @dataProvider nonTestEnvProvider */
    public function testIsFalseIfNotSetToTest(AppEnvironment $appEnvironment): void
    {
        $this->assertFalse($appEnvironment->isTest());
    }

    private function nonProdEnvProvider(): array
    {
        return [
            [AppEnvironment::DEV],
            [AppEnvironment::TEST]
        ];
    }

    private function nonTestEnvProvider(): array
    {
        return [
            [AppEnvironment::DEV],
            [AppEnvironment::PROD]
        ];
    }
}
