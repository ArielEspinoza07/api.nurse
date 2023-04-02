<?php

declare(strict_types=1);

namespace Src\shared\Domain\Mail;

use Src\shared\Domain\Validation\AssertNotNullable;
use Src\shared\Domain\ValueObject\StringValueObject;

class MailTo
{
    private function __construct(
        private readonly MailFromAddress $address,
        private readonly MailFromName|null $name = null
    ) {
    }

    public static function create(MailFromAddress $address, MailFromName|null $name = null): MailTo
    {
        return new static($address, $name);
    }

    public function address(): MailFromAddress
    {
        return $this->address;
    }

    public function name(): MailFromName|null
    {
        return $this->name;
    }
}
