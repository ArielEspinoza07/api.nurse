<?php

namespace Src\shared\Domain\Mail\Contract;

use Src\shared\Domain\Mail\DomainMail;

interface MailerContract
{
    public function send(DomainMail $mail): void;
}
