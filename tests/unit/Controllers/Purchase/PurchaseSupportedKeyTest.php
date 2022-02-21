<?php

namespace Froepstorf\UnitTest\Controllers\Purchase;

use Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseSupportedKey;
use Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys;
use PHPUnit\Framework\TestCase;

/** @covers \Froepstorf\Cryptoportfolio\Controllers\Purchase\PurchaseSupportedKey */
class PurchaseSupportedKeyTest extends TestCase
{
    private const COIN_NAME_KEY = 'coinName';
    private const AMOUNT_KEY = 'amount';
    private const PRICE_KEY = 'price';
    private const CURRENCY_KEY = 'currency';

    public function testCanGetCorrectCoinNameKey(): void
    {
        $this->assertSame(PurchaseSupportedKey::COIN_NAME_KEY->value, self::COIN_NAME_KEY);
    }

    public function testCanGetCorrectAmountKey(): void
    {
        $this->assertSame(PurchaseSupportedKey::AMOUNT_KEY->value, self::AMOUNT_KEY);
    }

    public function testCanGetCorrectPriceKey(): void
    {
        $this->assertSame(PurchaseSupportedKey::PRICE_KEY->value, self::PRICE_KEY);
    }

    public function testCanGetCorrectCurrencyKey(): void
    {
        $this->assertSame(PurchaseSupportedKey::CURRENCY_KEY->value, self::CURRENCY_KEY);
    }

    public function testCanGetKeyValues(): void
    {
        $this->assertInstanceOf(ValidatableBodyKeys::class, PurchaseSupportedKey::getKeyValues());
    }
}
