<?php

namespace Tests\Unit\app\Services\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\ResponseExceptionHandler;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Mockery\MockInterface;
use Tests\TestCase;

class ResponseExceptionHandlerTest extends TestCase
{
    public function test_response_exception_handler_return_json_response(): void
    {
        $exception = new InvalidArgumentException('Invalid argument name');

        $this->mock(ResponseBuilderContract::class, function (MockInterface $mock) {
            $mock->shouldReceive('build')
                ->once()
                ->andReturn(new JsonResponse());
        });

        $response = app(ResponseExceptionHandler::class)->handle($exception);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
