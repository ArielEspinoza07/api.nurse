<?php

namespace Src\shared\Domain\Validation;

use InvalidArgumentException;

trait AssertIsValidEmailAddress
{
    public function assertIsValidEmailAddress(string $emailAddress): void
    {
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid argument, has to be an email [%s]', $emailAddress));
        }
    }
}
