<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

// Aren't cryptoCoins also currencies? chec if consolidation makes sense
enum SupportedCurrencies: string
{
    case USD = 'USD';
    case EUR = 'EUR';
}