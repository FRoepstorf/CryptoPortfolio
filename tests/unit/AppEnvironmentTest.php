<?php
declare(strict_types=1);

namespace Froepstorf\UnitTest;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use PHPUnit\Framework\TestCase;

/** @covers AppEnvironment */
class AppEnvironmentTest extends TestCase
{
    public function testIsProdReturnsTrueIfProd(): void
    {
        $appEnvironment = AppEnvironment::from('prod');

        $this->assertTrue($appEnvironment->isProd());
    }

    /** @dataProvider nonProdEnvProvider  */
    public function testIsFalseIfNotSetToProd(AppEnvironment $appEnvironment): void
    {
        $this->assertFalse($appEnvironment->isProd());
    }

    private function nonProdEnvProvider(): array
    {
        return [
            [AppEnvironment::DEV],
            [AppEnvironment::TEST]
        ];
    }
}
