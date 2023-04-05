<?php

namespace Src\shared\Domain\Mail\Exception;

use RuntimeException;

class MailCanNotBeSendException extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct(
            sprintf('Email exception: Error happened at the moment of send the email, %s', $message),
            500
        );
    }
}
