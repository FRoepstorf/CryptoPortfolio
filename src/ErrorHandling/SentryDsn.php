<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\ErrorHandling;

final class SentryDsn
{
    public function __construct(
        public readonly string $value
    ) {
    }
}
