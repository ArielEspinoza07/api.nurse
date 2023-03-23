<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use Exception;

class AuthUserEmailAlreadyVerifiedException extends Exception
{
    public function __construct()
    {
        parent::__construct(
            'Email already verified.',
            400
        );
    }
}
