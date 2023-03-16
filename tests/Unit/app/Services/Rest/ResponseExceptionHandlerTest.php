<?php

namespace Tests\Unit\app\Services\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use App\Services\Rest\Json\ResponseExceptionHandler;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResponseExceptionHandlerTest extends TestCase
{
    public function test_response_exception_handler_return_json_response(): void
    {
        $exception = new InvalidArgumentException('Invalid argument name', Response::HTTP_BAD_REQUEST);

        $dto = new ResponseBuilderInputDTO(
            $exception->getMessage(),
            null,
            $exception->getCode(),
            false,
        );

        $responseBuilderContract = Mockery::mock(ResponseBuilderContract::class);
        $this->app->instance(ResponseExceptionHandler::class, $responseBuilderContract);

        $responseBuilderContract->shouldReceive('build')
            ->once()
            ->with(
                Mockery::on(function (ResponseBuilderInputDTO $inputDTO) use ($dto) {
                    return $dto->code === $inputDTO->code
                        && $dto->message === $inputDTO->message
                        && $dto->success === $inputDTO->success
                        && $dto->data === $inputDTO->data;
                })
            )
            ->andReturn(
                new JsonResponse(
                    [
                        "success" => $dto->success,
                        "message" => $dto->message,
                        "data" => $dto->data,
                    ],
                    $dto->code
                )
            );

        $responseExceptionHandler = (new ResponseExceptionHandler($responseBuilderContract))->handle($exception);

        $this->assertInstanceOf(JsonResponse::class, $responseExceptionHandler);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $responseExceptionHandler->getStatusCode());
        $this->assertEquals(
            '{"success":false,"message":"Invalid argument name","data":null}',
            $responseExceptionHandler->content()
        );
    }
}
