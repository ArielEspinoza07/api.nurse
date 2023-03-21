<?php

namespace Src\shared\Infrastructure\Response\Exception;

use Src\shared\Domain\Exception\ExceptionMessage;
use Throwable;

class ExceptionMessageBuilder
{
    public function build(Throwable $throwable): ExceptionMessage
    {
        if (method_exists($throwable, 'statustext')) {
            return ExceptionMessage::create($throwable->statustext());
        }
        if (!empty($throwable->getMessage())) {
            return ExceptionMessage::create($throwable->getMessage());
        }

        return ExceptionMessage::create('Internal Server Error');
    }
}
