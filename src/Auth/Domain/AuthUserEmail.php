<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use InvalidArgumentException;
use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserEmail extends StringValueObject
{
    use AssertNotNullable;

    protected function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
        $this->assertIsEmail($this->value);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }

    private function assertIsEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid argument, has to be an email [%s]', $email));
        }
    }
}
