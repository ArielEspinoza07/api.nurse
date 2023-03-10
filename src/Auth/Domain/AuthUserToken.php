<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\Validation\Contract\AssertValueLength;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserToken extends StringValueObject
{
    use AssertValueLength;

    public function __construct(protected string $value)
    {
        parent::__construct($this->value);

        if (! empty($this->value)) {
            $this->assertValueLength($this->value, 42);
        }
    }
}
