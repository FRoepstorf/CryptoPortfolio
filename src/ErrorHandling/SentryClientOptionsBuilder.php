<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\ErrorHandling;

use Froepstorf\Cryptoportfolio\AppEnvironment;
use Sentry\Options;

final class SentryClientOptionsBuilder
{
    private const DSN_KEY = 'dsn';
    private const ENVIRONMENT_KEY = 'environment';
    private const ATTACH_STACK_TRACE_KEY = 'attach_stacktrace';
    private const DEFAULT_INTEGRATIONS_KEY = 'default_integrations';

    private readonly array $options;

    public function __construct(private readonly SentryDsn $sentryDsn, private readonly AppEnvironment $appEnvironment)
    {
        $this->options = [
            self::DSN_KEY => $this->appEnvironment->isTestOrDev() ? null : $this->sentryDsn->value,
            self::ENVIRONMENT_KEY => $this->appEnvironment->value,
            self::ATTACH_STACK_TRACE_KEY => true,
            self::DEFAULT_INTEGRATIONS_KEY => true
        ];
    }

    public function build(): Options
    {
        return new Options($this->options);
    }
}