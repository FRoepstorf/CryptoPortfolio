<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\User;

use Fig\Http\Message\StatusCodeInterface;
use Froepstorf\Cryptoportfolio\Controllers\AbstractController;
use Froepstorf\Cryptoportfolio\Services\UserService;
use Psr\Log\LoggerInterface;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UserController extends AbstractController
{
    public function __construct(
        LoggerInterface $logger,
        private readonly UserService $userService,
        private readonly UserRequestMapper $userRequestMapper
    ) {
        parent::__construct($logger);
    }

    public function create(Request $request, Response $response): Response
    {
        $user = $this->userRequestMapper->mapCreateUserRequest($request);

        $this->userService->handleNewUser($user);

        return $response->withStatus(StatusCodeInterface::STATUS_CREATED);
    }
}
