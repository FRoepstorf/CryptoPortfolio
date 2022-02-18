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
        return match($this) {
            self::PROD => true,
            default => false,
        };
    }
}