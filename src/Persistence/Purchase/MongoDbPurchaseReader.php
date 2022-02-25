<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection\PurchaseCollection;
use MongoDB\Collection;

class MongoDbPurchaseReader implements PurchaseReader
{
    private Collection $collection;

    public function __construct(private readonly PurchaseCollection $purchaseCollection)
    {
        $this->collection = $this->purchaseCollection->collection;
    }

    public function read(): void
    {

    }
}