<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use RuntimeException;
use Src\Auth\Domain\AuthUserEmail;
use Src\shared\Domain\EmailAddress;

class InvalidAuthUserPasswordException extends RuntimeException
{
    public function __construct(EmailAddress $email)
    {
        parent::__construct(
            sprintf('Authentication failed: The credentials for [%s] are invalid', $email->value()),
            401
        );
    }
}
