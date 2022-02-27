<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;

interface PurchaseWriter
{
    public function store(Purchase $purchase, UserId $userId): void;
}