<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers;

use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Response;

class RootController extends AbstractController
{
    #[Pure] public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    public function root(Response $response): ResponseInterface
    {
        $this->getLogger()->info('Root request received');
        $response->getBody()->write('Hello World!');

        return $response;
    }
}