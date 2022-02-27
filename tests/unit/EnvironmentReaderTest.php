<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\EnvironmentReader;
use Froepstorf\Cryptoportfolio\Exception\EnvironmentVariableNotFoundException;
use PHPUnit\Framework\TestCase;

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

    public function testCanGetSentryDsn(): void
    {
        $this->assertSame('StubbedDsn', EnvironmentReader::getSentryDsn());
    }

    public function testCanGetMongoDbDatabaseName(): void
    {
        $this->assertSame('test', EnvironmentReader::getMongoDatabaseName());
    }

    public function testCanGetMongoDsn(): void
    {
        // TODO will break in CI when connecting outside of docker-compose dns
        $this->assertSame('mongodb://root:root@mongodb:27017', EnvironmentReader::getMongoDsn());
    }
}
