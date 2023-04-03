<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use InvalidArgumentException;
use Src\shared\Domain\Validation\AssertIsValidEmailAddress;
use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserEmail extends StringValueObject
{
    use AssertIsValidEmailAddress;
    use AssertNotNullable;

    protected function __construct(protected readonly string $value, private AuthUserEmailVerify $emailVerify)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
        $this->assertIsValidEmailAddress($this->value);
    }

    public static function create(string $value, AuthUserEmailVerify $emailVerify): self
    {
        return new static($value, $emailVerify);
    }

    public static function createNotVerified(string $value): self
    {
        return new static($value, AuthUserEmailVerify::createNotVerified());
    }

    public function emailVerify(): AuthUserEmailVerify
    {
        return $this->emailVerify;
    }

    public function setEmailVerify(AuthUserEmailVerify $emailVerify): void
    {
        $this->emailVerify = $emailVerify;
    }
}
