<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

class MedicalServiceIsActive
{
    public function __construct(protected bool $value)
    {
    }

    public static function createActive(): self
    {
        return new static(true);
    }

    public function value(): bool
    {
        return $this->value;
    }
}
