<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;

class PurchaseRepository
{
    public function __construct(private PurchaseReader $purchaseReader, private PurchaseWriter $purchaseWriter)
    {
    }

    public function store(Purchase $purchase): void
    {
        $this->purchaseWriter->store($purchase);
    }

    public function read(): void
    {
        $this->purchaseReader->read();
    }
}