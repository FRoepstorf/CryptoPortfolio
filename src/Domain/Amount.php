<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

final class Amount
{
    public function __construct(
        public readonly float $value
    ) {
    }
}
