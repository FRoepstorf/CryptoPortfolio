<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection;

use MongoDB\Collection;

class PurchaseCollection
{
    public function __construct(public readonly Collection $collection)
    {
    }
}