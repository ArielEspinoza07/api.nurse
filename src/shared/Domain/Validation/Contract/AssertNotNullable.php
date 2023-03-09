<?php

declare(strict_types=1);

namespace Src\shared\Domain\Validation\Contract;

use InvalidArgumentException;

trait AssertNotNullable
{
    public function assertNotNull(mixed $arg): void
    {
        if (is_null($arg)) {
            throw  new InvalidArgumentException('Invalid argument, can not be null', 400);
        }
    }
}
