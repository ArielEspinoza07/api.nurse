<?php

declare(strict_types=1);

namespace Src\shared\Domain\Validation\Contract;

use InvalidArgumentException;

trait AssertValueLength
{
    public function assertValueLength(string $arg, int $length = 3): void
    {
        if(strlen($arg) < $length) {
            throw  new InvalidArgumentException(sprintf('Invalid argument [%s], value must be min %s', $arg, $length), 400);
        }
    }
}
