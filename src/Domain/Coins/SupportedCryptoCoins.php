<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain\Coins;

enum SupportedCryptoCoins: string
{
    case AXS = 'AXS';
    case BTC = 'BTC';
}