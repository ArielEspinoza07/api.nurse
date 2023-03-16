<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use Exception;

class AuthUserNotFoundException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'User not found',
            404
        );
    }
}
