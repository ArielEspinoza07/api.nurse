<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\ValueObject\IntValueObject;

class MedicalServiceId extends IntValueObject
{
    use AssertNotNullable;

    public function __construct(protected int $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
    }

    public static function none(): self
    {
        return new static(0);
    }
}
