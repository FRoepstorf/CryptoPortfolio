<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\Purchase;

use Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys;

enum PurchaseSupportedKey: string
{
    case COIN_NAME_KEY = 'coinName';
    case AMOUNT_KEY = 'amount';
    case PRICE_KEY = 'price';
    case CURRENCY_KEY = 'currency';

    public static function getKeyValues(): ValidatableBodyKeys
    {
        $arrayKeys = array_map(
            fn(PurchaseSupportedKey $purchaseSupportedKey) => $purchaseSupportedKey->value,
            self::cases()
        );

        return new ValidatableBodyKeys($arrayKeys);
    }
}