<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers;

use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Response;

class RootController
{
    public function root(Response $response): ResponseInterface
    {
        $response->getBody()->write('Hello World!');

        return $response;
    }
}