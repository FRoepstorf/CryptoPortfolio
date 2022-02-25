<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection;

use MongoDB\Collection;

class PurchaseCollection
{
    public const COIN_NAME_KEY = 'coinName';
    public const AMOUNT_KEY = 'amount';
    public const PRICE_KEY = 'price';
    public const CURRENCY_KEY = 'currency';
    public const USER_ID_KEY = 'userId';

    public function __construct(public readonly Collection $collection)
    {
    }
}