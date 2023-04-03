<?php

declare(strict_types=1);

namespace Src\shared\Domain\Mail;

use Src\shared\Domain\Validation\AssertIsBetweenAcceptedValues;
use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class MailContentType extends StringValueObject
{
    use AssertIsBetweenAcceptedValues;
    use AssertNotNullable;

    public const TEXT_HTML = 'text/html';
    public const TEXT_PLAIN = 'text/plain';

    protected function __construct(protected readonly string $value)
    {
        parent::__construct($this->value);
        $this->assertNotNull($this->value);
        $this->assertIsBetweenAcceptedValues($this->value, [self::TEXT_HTML, self::TEXT_PLAIN]);
    }

    public static function create(string $value): MailContentType
    {
        return new static($value);
    }
}
