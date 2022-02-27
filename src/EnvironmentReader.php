<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

use Froepstorf\Cryptoportfolio\Exception\EnvironmentVariableNotFoundException;

class EnvironmentReader
{
    public static function getAppEnvironment(): AppEnvironment
    {
        return AppEnvironment::from(self::readFromEnvironment('APP_ENVIRONMENT'));
    }

    public static function getMongoDsn(): string
    {
        return self::readFromEnvironment('MONGO_DSN');
    }

    public static function getSentryDsn(): string
    {
        return self::readFromEnvironment('SENTRY_DSN');
    }

    public static function getMongoDatabaseName(): string
    {
        return self::readFromEnvironment('MONGO_DATABASE_NAME');
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
