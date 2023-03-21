<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Exception;

use Src\shared\Domain\Exception\ExceptionCode;
use Src\shared\Infrastructure\Response\Exception\ExceptionCodeBuilder;
use Symfony\Component\HttpFoundation\Response;

class ExceptionCodeBuilderTest extends ExceptionResponseTestBase
{
    public function test_return_exception_code(): void
    {
        $exception = $this->createException();

        $exceptionCode = (new ExceptionCodeBuilder())->build($exception);

        $this->assertInstanceOf(ExceptionCode::class, $exceptionCode);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $exceptionCode->value());
    }
}
