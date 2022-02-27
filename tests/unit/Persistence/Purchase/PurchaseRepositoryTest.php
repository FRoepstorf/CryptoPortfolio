<?php

declare(strict_types=1);

namespace Froepstorf\UnitTest\Persistence\Purchase;

use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseReader;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository;
use Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseWriter;
use Froepstorf\Cryptoportfolio\Persistence\User\UserId;
use Froepstorf\Fixtures\PurchaseProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Persistence\Purchase\PurchaseRepository */
class PurchaseRepositoryTest extends TestCase
{
    private PurchaseReader|MockObject $purchaseReaderMock;

    private PurchaseWriter|MockObject $purchaseWriterMock;

    private PurchaseRepository $purchaseRepository;

    protected function setUp(): void
    {
        $this->purchaseReaderMock = $this->createMock(PurchaseReader::class);
        $this->purchaseWriterMock = $this->createMock(PurchaseWriter::class);
        $this->purchaseRepository = new PurchaseRepository($this->purchaseReaderMock, $this->purchaseWriterMock);
    }

    public function testCanStorePurchase(): void
    {
        $purchase = PurchaseProvider::build();

        $this->purchaseWriterMock->expects($this->once())
            ->method('store')
            ->with($purchase);

        $userId = $this->createMock(UserId::class);

        $this->purchaseRepository->store($purchase, $userId);
    }

    public function testCanReadPurchase(): void
    {
        $this->purchaseReaderMock->expects($this->once())
            ->method('read');

        $this->purchaseRepository->read();
    }
}
