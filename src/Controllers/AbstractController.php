<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers;

use Psr\Log\LoggerInterface;

abstract class AbstractController
{
    public function __construct(private LoggerInterface $logger)
    {
    }

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }
}