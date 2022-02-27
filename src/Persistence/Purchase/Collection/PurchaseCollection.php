<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection;

use MongoDB\Collection;

class PurchaseCollection
{
    /**
     * @var string
     */
    final public const COIN_NAME_KEY = 'coinName';

    /**
     * @var string
     */
    final public const AMOUNT_KEY = 'amount';

    /**
     * @var string
     */
    final public const PRICE_KEY = 'price';

    /**
     * @var string
     */
    final public const CURRENCY_KEY = 'currency';

    /**
     * @var string
     */
    final public const USER_ID_KEY = 'userId';

    public function __construct(
        public readonly Collection $collection
    ) {
    }
}
