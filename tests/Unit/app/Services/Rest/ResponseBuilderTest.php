<?php

namespace Tests\Unit\app\Services\Rest;

use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use App\Services\Rest\Json\DTO\ResponseInputDTO;
use App\Services\Rest\Json\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Mockery;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResponseBuilderTest extends TestCase
{

    public function test_response_builder_return_json_response(): void
    {
        $dto = new ResponseBuilderInputDTO(
            'Ok.'
        );

        $responseContract = Mockery::mock(ResponseContract::class);
        $this->app->instance(ResponseBuilder::class, $responseContract);

        $responseContract->shouldReceive('handle')
            ->once()
            ->with(
                Mockery::on(function (ResponseInputDTO $inputDTO) use ($dto) {
                    return $dto->code === $inputDTO->code
                        && $dto->message === $inputDTO->data['message']
                        && $dto->success === $inputDTO->data['success']
                        && $dto->data === $inputDTO->data['data'];
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

        $responseBuilder = (new ResponseBuilder($responseContract))->build($dto);

        $this->assertInstanceOf(JsonResponse::class, $responseBuilder);

        $this->assertEquals(Response::HTTP_OK, $responseBuilder->getStatusCode());
        $this->assertEquals('{"success":true,"message":"Ok.","data":null}', $responseBuilder->content());
    }
}
