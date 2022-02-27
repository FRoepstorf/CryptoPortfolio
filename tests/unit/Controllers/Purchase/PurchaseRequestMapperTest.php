<?php

namespace Froepstorf\UnitTest\Controllers\Purchase;

use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseRequestMapper;
use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseSupportedKey;
use Froepstorf\Cryptoportfolio\Domain\Purchase;
use Froepstorf\Cryptoportfolio\Exception\ExpectedKeyIsNotSetException;
use Froepstorf\Cryptoportfolio\Exception\InvalidParsedBodyException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Slim\Psr7\Request;

/** @covers \Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseRequestMapper */
class PurchaseRequestMapperTest extends TestCase
{
    private PurchaseRequestMapper $purchaseRequestMapper;

    private Request|MockObject $request;

    protected function setUp(): void
    {
        $this->purchaseRequestMapper = new PurchaseRequestMapper();
        $this->request = $this->createMock(Request::class);
    }

    public function testReturnsPurchaseIfEverythingIsCorrectlyValidated(): void
    {
        $this->request->method('getParsedBody')
            ->willReturn([
                PurchaseSupportedKey::COIN_NAME_KEY->value => 'AXS',
                PurchaseSupportedKey::AMOUNT_KEY->value => 20.5,
                PurchaseSupportedKey::PRICE_KEY->value => '500000',
                PurchaseSupportedKey::CURRENCY_KEY->value => 'USD',
                PurchaseSupportedKey::USER_KEY->value => 'test'
            ]);

        $mappedPurchase = $this->purchaseRequestMapper->mapPurchase($this->request);

        $this->assertInstanceOf(Purchase::class, $mappedPurchase);
    }

    public function testThrowsExceptionIfParsedBodyIsNotArray(): void
    {
        $this->request->method('getParsedBody')
            ->willReturn(new \stdClass());

        $this->expectException(InvalidParsedBodyException::class);

        $this->purchaseRequestMapper->mapPurchase($this->request);
    }

    public function testThrowsExceptionIfKeysAreNotSet(): void
    {
        $this->request->method('getParsedBody')
            ->willReturn([]);

        $this->expectException(ExpectedKeyIsNotSetException::class);

        $this->purchaseRequestMapper->mapPurchase($this->request);
    }
}
