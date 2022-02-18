<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

class Amount
{
    public function __construct(private float $amount)
    {
    }

    public function asFloat(): float
    {
        return $this->amount;
    }
}