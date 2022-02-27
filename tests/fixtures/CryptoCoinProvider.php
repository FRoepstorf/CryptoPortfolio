<?php
declare(strict_types=1);

namespace Froepstorf\Fixtures;

use Froepstorf\Cryptoportfolio\Domain\Coins\CryptoCoin;

class CryptoCoinProvider
{
    public const COIN_NAME = 'AXS';

    public static function build(string $name = self::COIN_NAME): CryptoCoin
    {
        return new CryptoCoin($name);
    }
}