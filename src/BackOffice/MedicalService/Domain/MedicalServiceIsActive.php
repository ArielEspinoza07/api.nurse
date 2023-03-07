<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

class MedicalServiceIsActive
{

    public function __construct(protected bool $value = true)
    {
    }

    public function value(): bool
    {
        return $this->value;
    }
}
