<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Exception\Rest;

use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Src\shared\Infrastructure\Response\Exception\Rest\JsonException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class JsonExceptionTest extends TestCase
{
    public function test_return_json_response(): void
    {
        $exception = new InvalidArgumentException('Invalid argument name', Response::HTTP_BAD_REQUEST);

        $responseException = (new JsonException())->send($exception);

        $this->assertInstanceOf(JsonResponse::class, $responseException);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $responseException->getStatusCode());
        $this->assertEquals(
            '{"success":false,"message":"Invalid argument name","data":null}',
            $responseException->content()
        );
    }
}
