<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

enum SupportedCurrencies: string
{
    case USD = 'USD';
    case EUR = 'EUR';
}