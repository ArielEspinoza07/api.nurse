<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

use Src\shared\Domain\Validation\AssertNotNullable;

class MedicalServiceIsActive
{
    use AssertNotNullable;

    private function __construct(private readonly bool $value)
    {
        $this->assertNotNull($this->value);
    }

    public static function create(bool $value): self
    {
        return new static($value);
    }

    public static function createActive(): self
    {
        return new static(true);
    }

    public function isEquals(MedicalServiceIsActive $name): bool
    {
        return $this->value === $name->value();
    }

    public function value(): bool
    {
        return $this->value;
    }
}
