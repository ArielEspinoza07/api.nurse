<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use RuntimeException;

class InvalidAuthUserEmailException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'Authentication failed: User was not found matching the entered credentials',
            404
        );
    }
}
