<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio;

enum AppEnvironment: string
{
    case DEV = 'dev';
    case TEST = 'test';
    case PROD = 'prod';

    public function isProd(): bool
    {
        return match ($this) {
            self::PROD => true,
            default => false,
        };
    }

    public function isTest(): bool
    {
        return match ($this) {
            self::TEST => true,
            default => false
        };
    }

    public function isTestOrDev(): bool
    {
        return match ($this) {
            self::TEST, self::DEV => true,
            default => false
        };
    }
}
