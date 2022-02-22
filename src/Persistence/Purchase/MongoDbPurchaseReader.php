<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

use MongoDB\Client;

class MongoDbPurchaseReader implements PurchaseReader
{

    public function __construct(private readonly Client $mongoClient)
    {
    }

    public function read(): void
    {

    }
}