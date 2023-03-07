<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserEmail extends StringValueObject
{
    use AssertNotNullable;

    public function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
        $this->assertIsEmail($this->value);
    }

    private function assertIsEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('Invalid argument, has to be an email [%s]', $email));
        }
    }
}
