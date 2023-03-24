<?php

declare(strict_types=1);

namespace Src\Auth\Domain\Exception;

use RuntimeException;

class InvalidOrExpiredUrlException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct(
            'Invalid or Expired url provided.',
            401
        );
    }
}
