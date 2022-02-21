<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;

interface PurchaseWriter
{
    public function store(Purchase $purchase): void;
}