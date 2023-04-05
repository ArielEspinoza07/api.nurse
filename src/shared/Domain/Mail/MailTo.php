<?php

declare(strict_types=1);

namespace Src\shared\Domain\Mail;

use Src\shared\Domain\EmailAddress;

class MailTo
{
    private function __construct(
        private readonly EmailAddress $address,
        private readonly MailFromName|null $name = null
    ) {
    }

    public static function create(EmailAddress $address, MailFromName|null $name = null): MailTo
    {
        return new static($address, $name);
    }

    public function address(): EmailAddress
    {
        return $this->address;
    }

    public function name(): MailFromName|null
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'email' => $this->address->value(),
            'name' => $this->name->value(),
        ];
    }
}
