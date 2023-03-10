<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain;

use Src\shared\Domain\Validation\Contract\AssertNotNullable;
use Src\shared\Domain\Validation\Contract\AssertValueLength;
use Src\shared\Domain\ValueObject\StringValueObject;

class MedicalServiceName extends StringValueObject
{
    use AssertNotNullable;
    use AssertValueLength;

    public function __construct(protected string $value)
    {
        parent::__construct($this->value);

        $this->assertNotNull($this->value);
        $this->assertValueLength($this->value);
    }
}
