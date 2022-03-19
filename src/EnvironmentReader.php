<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use Froepstorf\Cryptoportfolio\ErrorHandling\SentryDsn;
use Froepstorf\Cryptoportfolio\Exception\EnvironmentVariableNotFoundException;

class EnvironmentReader
{
    public static function getAppEnvironment(): AppEnvironment
    {
        return AppEnvironment::from(self::readFromEnvironment('APP_ENVIRONMENT'));
    }

    public static function getSentryDsn(): SentryDsn
    {
        return new SentryDsn(self::readFromEnvironment('SENTRY_DSN'));
    }

    private static function readFromEnvironment(string $key): string
    {
        $envVariable = getenv($key);
        if ($envVariable === false) {
            throw new EnvironmentVariableNotFoundException(
                sprintf('The requested environment variable "%s" was not found', $key)
            );
        }

        return $envVariable;
    }
}
