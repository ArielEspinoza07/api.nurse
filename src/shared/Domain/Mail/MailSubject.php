<?php

declare(strict_types=1);

namespace Src\shared\Domain\Mail;

use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class MailSubject extends StringValueObject
{
    use AssertNotNullable;

    protected function __construct(protected readonly string $value)
    {
        parent::__construct($this->value);
        $this->assertNotNull($this->value);
    }

    public static function create(string $value): MailSubject
    {
        return new static($value);
    }
}
