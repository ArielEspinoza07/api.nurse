<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use RuntimeException;
use Src\Auth\Domain\AuthUserEmail;

class InvalidAuthUserPasswordException extends RuntimeException
{
    public function __construct(AuthUserEmail $email)
    {
        parent::__construct(
            sprintf('Authentication failed: The credentials for [%s] are invalid', $email->value()),
            401
        );
    }
}
