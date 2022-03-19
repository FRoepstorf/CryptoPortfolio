<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\Exception\EnvironmentVariableNotFoundException;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\EnvironmentReader */
class EnvironmentReaderTest extends TestCase
{
    protected function setUp(): void
    {
        putenv('APP_ENVIRONMENT=test');
    }

    protected function tearDown(): void
    {
        putenv('APP_ENVIRONMENT=test');
    }

    public function testCanGetAppEnvironmentFromEnvironment(): void
    {
        $this->assertInstanceOf(AppEnvironment::class, EnvironmentReader::getAppEnvironment());
    }

    public function testThrowsExceptionIfTryingToReadNonExistantEnvVariable(): void
    {
        putenv('APP_ENVIRONMENT');
        $this->expectException(EnvironmentVariableNotFoundException::class);

        EnvironmentReader::getAppEnvironment();
    }
}
