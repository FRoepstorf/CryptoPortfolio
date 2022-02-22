<?php
declare(strict_types=1);

namespace Froepstorf\Cryptoportfolio\Controllers\User;

use Froepstorf\Cryptoportfolio\Controllers\Validators\HasValidatableBodyKeys;
use Froepstorf\Cryptoportfolio\Controllers\Validators\ValidatableBodyKeys;

enum CreateUserSupportedKey: string implements HasValidatableBodyKeys
{
    case USER_NAME = 'userName';


    public static function getKeyValues(): ValidatableBodyKeys
    {
        $arrayKeys = array_map(
            fn(CreateUserSupportedKey $createUserSupportedKey) => $createUserSupportedKey->value,
            self::cases()
        );

        return new ValidatableBodyKeys($arrayKeys);
    }
}