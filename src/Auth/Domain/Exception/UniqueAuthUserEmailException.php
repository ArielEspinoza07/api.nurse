<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use RuntimeException;

class UniqueAuthUserEmailException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'Registration failed: The email is already associated with an account.',
            400
        );
    }
}
