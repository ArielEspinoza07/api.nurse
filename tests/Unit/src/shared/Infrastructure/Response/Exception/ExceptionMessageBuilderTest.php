<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Exception;

use Src\shared\Domain\Exception\ExceptionMessage;
use Src\shared\Infrastructure\Response\Exception\ExceptionMessageBuilder;

class ExceptionMessageBuilderTest extends ExceptionResponseTestBase
{
    public function test_return_exception_message(): void
    {
        $exception = $this->createException();

        $exceptionMessage = (new ExceptionMessageBuilder())->build($exception);

        $this->assertInstanceOf(ExceptionMessage::class, $exceptionMessage);

        $this->assertEquals($exception->getMessage(), $exceptionMessage->value());
    }
}
