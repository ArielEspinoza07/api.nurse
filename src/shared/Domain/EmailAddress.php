<?php

declare(strict_types=1);

namespace Src\shared\Domain;

use Src\shared\Domain\Validation\AssertIsValidEmailAddress;
use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class EmailAddress extends StringValueObject
{
    use AssertIsValidEmailAddress;
    use AssertNotNullable;

    protected function __construct(protected string $value)
    {
        parent::__construct($this->value);
        $this->assertNotNull($this->value);
        $this->assertIsValidEmailAddress($this->value);
    }

    public static function create(string $value): EmailAddress
    {
        return new static($value);
    }
}
