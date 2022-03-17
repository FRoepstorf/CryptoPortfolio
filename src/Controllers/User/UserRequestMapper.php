<?php

declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\User;

use Froepstorf\Cryptoportfolio\Controllers\Validators\ParsedBodyValidator;
use Froepstorf\Cryptoportfolio\Domain\User;
use Slim\Psr7\Request;

class UserRequestMapper
{
    public function mapCreateUserRequest(Request $request): User
    {
        /** @psalm-var array<string, non-empty-string> $parsedBody */
        $parsedBody = $request->getParsedBody();
        ParsedBodyValidator::ensuresParsedBodyIsArray($parsedBody);
        ParsedBodyValidator::ensureKeysAreSet($parsedBody, CreateUserSupportedKey::getKeyValues());

        return new User($parsedBody[CreateUserSupportedKey::USER_NAME->value]);
    }
}
