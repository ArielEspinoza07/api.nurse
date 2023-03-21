<?php

namespace Src\shared\Infrastructure\Response\Exception;

use Src\shared\Domain\Exception\ExceptionData;
use Throwable;

class ExceptionDataBuilder
{
    public function build(Throwable $throwable): ExceptionData
    {
        if (method_exists($throwable, 'getMessageBag')) {
            return ExceptionData::create($throwable->getMessageBag()->getMessages());
        }
        if (property_exists($throwable, 'validator')) {
            return ExceptionData::create($throwable->validator->errors()->getMessages());
        }

        return ExceptionData::empty();
    }
}
