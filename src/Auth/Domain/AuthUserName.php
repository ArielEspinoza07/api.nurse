<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserName extends StringValueObject
{

    public static function random(): self
    {
        $names = ['John', 'Peter', 'Maria'];

        return new static($names[rand(0, 3)]);
    }
}
