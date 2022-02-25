<?php
declare(strict_types=1);

namespace Froepstorf\Fixtures;

use Froepstorf\Cryptoportfolio\Domain\Purchase;

class PurchaseProvider
{
    public static function build(): Purchase
    {
        return new Purchase(
            CryptoCoinProvider::build(),
            AmountProvider::build(),
            PriceProvider::build(),
            UserProvider::build()
        );
    }
}