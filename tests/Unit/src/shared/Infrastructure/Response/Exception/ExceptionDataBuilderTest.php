<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Exception;

use Src\shared\Domain\Exception\ExceptionData;
use Src\shared\Infrastructure\Response\Exception\ExceptionDataBuilder;

class ExceptionDataBuilderTest extends ExceptionResponseTestBase
{
    public function test_return_exception_data(): void
    {
        $exception = $this->createException();

        $exceptionData = (new ExceptionDataBuilder())->build($exception);

        $this->assertInstanceOf(ExceptionData::class, $exceptionData);

        $this->assertNull($exceptionData->value());
    }
}
