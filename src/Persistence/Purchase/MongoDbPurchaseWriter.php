<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection\PurchaseCollection;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use MongoDB\Client;
use MongoDB\Collection;

class MongoDbPurchaseWriter implements PurchaseWriter
{
    private readonly Collection $collection;

    public function __construct(PurchaseCollection $purchaseCollection)
    {
        $this->collection = $purchaseCollection->collection;
    }

    public function store(Purchase $purchase, UserId $userId): void
    {
        $this->collection->insertOne([
            PurchaseCollection::COIN_NAME_KEY => $purchase->cryptoCoin->coinName,
            PurchaseCollection::AMOUNT_KEY => $purchase->amount->value,
            PurchaseCollection::PRICE_KEY => $purchase->price->asMoney()->getAmount(),
            PurchaseCollection::CURRENCY_KEY => $purchase->price->asMoney()->getCurrency()->getCode(),
            PurchaseCollection::USER_ID_KEY => $userId->asString()
        ]);
    }
}