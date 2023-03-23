<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use InvalidArgumentException;
use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class AuthUserEmail extends StringValueObject
{
    use AssertNotNullable;

    protected function __construct(protected string $value, private AuthUserEmailVerify $emailVerify)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
        $this->assertIsEmail($this->value);
    }

    public static function create(string $value, AuthUserEmailVerify $emailVerify): self
    {
        return new static($value, $emailVerify);
    }

    public static function createNotVerified(string $value): self
    {
        return new static($value, AuthUserEmailVerify::createNotVerified());
    }

    private function assertIsEmail(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid argument, has to be an email [%s]', $email));
        }
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
