<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use MongoDB\Client;
use MongoDB\Collection;

class MongoDbPurchaseWriter implements PurchaseWriter
{
    private Collection $collection;

    public function __construct(private readonly Client $mongoClient)
    {
        $this->collection = $this->mongoClient->selectCollection('test', 'purchase');
    }

    public function store(Purchase $purchase, UserId $userId): void
    {
        $this->collection->insertOne([
            'coinName' => $purchase->cryptoCoin->coinName,
            'amount' => $purchase->amount->value,
            'price' => $purchase->price->asMoney()->getAmount(),
            'currency' => $purchase->price->asMoney()->getCurrency()->getCode(),
            'userId' => $userId->asString()
        ]);
    }
}