<?php

namespace Tests\Unit\app\Services\Rest;

use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\DTO\ResponseInputDTO;
use App\Services\Rest\Json\ResponseExceptionBuilder;
use Illuminate\Http\JsonResponse;
use InvalidArgumentException;
use Mockery;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResponseExceptionHandlerTest extends TestCase
{
    public function test_response_exception_handler_return_json_response(): void
    {
        $exception = new InvalidArgumentException('Invalid argument name', Response::HTTP_BAD_REQUEST);

        $dto = ResponseInputDTO::createFromValues(
            $exception->getMessage(),
            $exception->getCode(),
            null,
            false,
        );

        $responseBuilderContract = Mockery::mock(ResponseContract::class);
        $this->app->instance(ResponseExceptionBuilder::class, $responseBuilderContract);

        $responseBuilderContract->shouldReceive('handle')
            ->once()
            ->with(
                Mockery::on(function (ResponseInputDTO $inputDTO) use ($dto) {
                    return $dto->code === $inputDTO->code
                        && $dto->data['success'] === $inputDTO->data['success']
                        && $dto->data['message'] === $inputDTO->data['message']
                        && $dto->data['data'] === $inputDTO->data['data'];
                })
            )
            ->andReturn(
                new JsonResponse(
                    $dto->data,
                    $dto->code
                )
            );

        $responseExceptionHandler = (new ResponseExceptionBuilder($responseBuilderContract))->handle($exception);

        $this->assertInstanceOf(JsonResponse::class, $responseExceptionHandler);

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $responseExceptionHandler->getStatusCode());
        $this->assertEquals(
            '{"success":false,"message":"Invalid argument name","data":null}',
            $responseExceptionHandler->content()
        );
    }
}
