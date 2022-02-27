<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Persistence\Purchase;

interface PurchaseReader
{
    public function read(): void;
}
