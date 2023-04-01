<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\Validation\AssertValueLength;
use Src\shared\Domain\ValueObject\StringValueObject;

class MedicalServiceName extends StringValueObject
{
    use AssertNotNullable;
    use AssertValueLength;

    public const MINIMUM_LENGTH = 3;

    protected function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
        $this->assertValueLength($this->value, self::MINIMUM_LENGTH);
    }

    public static function create(string $value): self
    {
        return new static($value);
    }

    public function change(string $value): void
    {
        $this->value = $value;
    }
}
