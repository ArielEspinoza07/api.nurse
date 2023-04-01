<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

use Src\shared\Domain\Validation\AssertNotNullable;

class MedicalServiceIsActive
{
    use AssertNotNullable;

    private function __construct(private bool $value)
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

    public function change(): void
    {
        $this->value = !$this->value;
    }

    public function value(): bool
    {
        return $this->value;
    }
}
