<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain\Coins;

//Likely to strict - should allow all valid coins(maybe fetch from api?)
enum SupportedCryptoCoins: string
{
    case AXS = 'AXS';
    case BTC = 'BTC';
}
