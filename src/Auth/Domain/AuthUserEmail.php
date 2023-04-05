<?php

declare(strict_types=1);

namespace Src\Auth\Domain;

use Src\shared\Domain\EmailAddress;

class AuthUserEmail
{
    private function __construct(
        protected readonly EmailAddress $emailAddress,
        private readonly EmailVerify $emailVerify
    ) {
    }

    public static function create(EmailAddress $emailAddress, EmailVerify $emailVerify): self
    {
        return new static($emailAddress, $emailVerify);
    }

    public static function createNotVerified(EmailAddress $emailAddress): self
    {
        return new static($emailAddress, EmailVerify::createNotVerified());
    }

    public function emailAddress(): EmailAddress
    {
        return $this->emailAddress;
    }

    public function emailVerify(): EmailVerify
    {
        return $this->emailVerify;
    }
}
