<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\Purchase\Collection;

use Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection\PurchaseCollection;
use MongoDB\Collection;
use PHPUnit\Framework\TestCase;

class PurchaseCollectionTest extends TestCase
{
    public function testCanGetMongoCollection(): void
    {
        $mongoCollection = $this->createMock(Collection::class);
        $purchaseCollection = new PurchaseCollection($mongoCollection);

        $this->assertSame($mongoCollection, $purchaseCollection->collection);
    }
}
