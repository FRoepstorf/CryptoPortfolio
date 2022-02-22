<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;
use MongoDB\Client;

class MongoDbPurchaseWriter implements PurchaseWriter
{
    public function __construct(private readonly Client $mongoClient)
    {
    }

    public function store(Purchase $purchase): void
    {
        $collection = $this->mongoClient->selectCollection('test', 'purchase');

        $collection->insertOne([
            'coinName' => $purchase->cryptoCoin->coinName,
            'amount' => $purchase->amount->value,
            'price' => $purchase->price->asMoney()->getAmount(),
            'currency' => $purchase->price->asMoney()->getCurrency()->getCode()
        ]);
    }
}