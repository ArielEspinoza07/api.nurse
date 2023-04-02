<?php

declare(strict_types=1);

namespace Src\shared\Domain\Mail;

use Src\shared\Domain\Validation\AssertNotNullable;

class MailContent
{
    use AssertNotNullable;

    private function __construct(private readonly MailContentType $contentType, private readonly string $value)
    {
        $this->assertNotNull($this->value);
    }

    public static function create(MailContentType $contentType, string $value): MailContent
    {
        return new static($contentType, $value);
    }

    public function contentType(): MailContentType
    {
        return $this->contentType;
    }

    public function value(): string
    {
        return $this->value;
    }
}
