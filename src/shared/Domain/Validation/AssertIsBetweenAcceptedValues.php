<?php

declare(strict_types=1);

namespace Src\shared\Domain\Validation;

use InvalidArgumentException;

trait AssertIsBetweenAcceptedValues
{
    public function assertIsBetweenAcceptedValues(mixed $value, array $values): void
    {
        if (!in_array($value, $values)) {
            throw new InvalidArgumentException(
                sprintf('Invalid argument [%s], must be [%d]', $value, implode(',', $values)),
                400
            );
        }
    }
}
