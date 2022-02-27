<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

final class User
{
    public function __construct(
        public readonly string $name
    ) {
    }
}
