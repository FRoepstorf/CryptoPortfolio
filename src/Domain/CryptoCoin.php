<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Domain;

class CryptoCoin
{
    public function __construct(private string $coinName)
    {
    }

    public function getName(): string
    {
        return $this->coinName;
    }
}