<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

class PurchaseRepository
{
    public function __construct(private PurchaseReader $purchaseReader, private PurchaseWriter $purchaseWriter)
    {
    }
}