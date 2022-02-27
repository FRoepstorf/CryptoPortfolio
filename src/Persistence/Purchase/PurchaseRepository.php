<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;

class PurchaseRepository
{
    public function __construct(
        private readonly PurchaseReader $purchaseReader,
        private readonly PurchaseWriter $purchaseWriter
    ) {
    }

    public function store(Purchase $purchase, UserId $userId): void
    {
        $this->purchaseWriter->store($purchase, $userId);
    }

    public function read(): void
    {
        $this->purchaseReader->read();
    }
}
