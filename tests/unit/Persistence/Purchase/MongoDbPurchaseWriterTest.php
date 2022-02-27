<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection\PurchaseCollection;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseWriter;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use Froepstorf\Fixtures\PurchaseProvider;
use MongoDB\Collection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\Purchase\MongoDbPurchaseWriter */
class MongoDbPurchaseWriterTest extends TestCase
{
    /**
     * @var string
     */
    private const USER_ID = '1234';

    private Collection|MockObject $collectionMock;

    private MongoDbPurchaseWriter $mongoDbPurchaseWriter;

    protected function setUp(): void
    {
        $this->collectionMock = $this->createMock(Collection::class);
        $purchaseCollection = new PurchaseCollection($this->collectionMock);

        $this->mongoDbPurchaseWriter = new MongoDbPurchaseWriter($purchaseCollection);
    }

    public function testCanStorePurchaseWithUserId(): void
    {
        $purchase = PurchaseProvider::build();

        $userIdMock = $this->createMock(UserId::class);
        $userIdMock->method('asString')
            ->willReturn(self::USER_ID);

        $this->collectionMock->expects($this->once())
            ->method('insertOne')
            ->with(
                [
                    PurchaseCollection::COIN_NAME_KEY => $purchase->cryptoCoin->coinName,
                    PurchaseCollection::AMOUNT_KEY => $purchase->amount->value,
                    PurchaseCollection::PRICE_KEY => $purchase->price->asMoney()->getAmount(),
                    PurchaseCollection::CURRENCY_KEY => $purchase->price->asMoney()->getCurrency()->getCode(),
                    PurchaseCollection::USER_ID_KEY => self::USER_ID,
                ]
            );

        $this->mongoDbPurchaseWriter->store($purchase, $userIdMock);
    }
}
