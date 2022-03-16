<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase\Collection;

use MongoDB\Collection;

class PurchaseCollection
{
    /** @var string */
    public final const COIN_NAME_KEY = 'coinName';

    /** @var string */
    public final const AMOUNT_KEY = 'amount';

    /** @var string */
    public final const PRICE_KEY = 'price';

    /** @var string */
    public final const CURRENCY_KEY = 'currency';

    /** @var string */
    public final const USER_ID_KEY = 'userId';

    public function __construct(
        public readonly Collection $collection
    ) {
    }
}
