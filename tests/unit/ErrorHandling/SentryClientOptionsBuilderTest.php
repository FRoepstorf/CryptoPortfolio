<?php

namespace Froepstorf\UnitTest\ErrorHandling;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryClientOptionsBuilder;
use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use PHPUnit\Framework\TestCase;
use Sentry\Options;

/** @covers \Froepstorf\Cryptoportfolio\ErrorHandling\SentryClientOptionsBuilder */
class SentryClientOptionsBuilderTest extends TestCase
{
    private const DSN_KEY = 'dsn';
    private const ENVIRONMENT_KEY = 'environment';
    private const ATTACH_STACK_TRACE_KEY = 'attach_stacktrace';
    private const DEFAULT_INTEGRATIONS_KEY = 'default_integrations';
    private const SENTRY_DSN = 'https://public@sentry.example.com/1';

    private SentryDsn $sentryDsn;

    private SentryClientOptionsBuilder $sentryClientOptionsBuilder;


    protected function setUp(): void
    {
        $this->sentryDsn = new SentryDsn(self::SENTRY_DSN);
    }

    public function testCanBuildOptionsForProdEnv(): void
    {
        $this->sentryClientOptionsBuilder = new SentryClientOptionsBuilder($this->sentryDsn, AppEnvironment::PROD);

        $actualOptions = $this->sentryClientOptionsBuilder->build();
        $expectedOptions = new Options([
            self::DSN_KEY => self::SENTRY_DSN,
            self::ENVIRONMENT_KEY => AppEnvironment::PROD->value,
            self::ATTACH_STACK_TRACE_KEY => true,
            self::DEFAULT_INTEGRATIONS_KEY => true
        ]);

        $this->assertEquals($expectedOptions, $actualOptions);
    }

    /** @dataProvider testAndDevEnvProvider */
    public function testCanBuildOptionsIfAppEnvIsTestOrDev(AppEnvironment $appEnvironment): void
    {
        $this->sentryClientOptionsBuilder = new SentryClientOptionsBuilder($this->sentryDsn, $appEnvironment);

        $actualOptions = $this->sentryClientOptionsBuilder->build();
        $expectedOptions = new Options([
            self::DSN_KEY => null,
            self::ENVIRONMENT_KEY => $appEnvironment->value,
            self::ATTACH_STACK_TRACE_KEY => true,
            self::DEFAULT_INTEGRATIONS_KEY => true
        ]);

        $this->assertEquals($expectedOptions, $actualOptions);
    }

    private function testAndDevEnvProvider(): array
    {
        return [
            [AppEnvironment::TEST],
            [AppEnvironment::DEV],
        ];
    }
}
