<?php

namespace Src\shared\Infrastructure\Mail\MailTrap\Exception;

use RuntimeException;

class MailtrapRequiredTextBodyException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('MailTrap Exception: text body is required', 500);
    }
}
