<?php

namespace Tests\Unit\app\Services\Rest;

use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use App\Services\Rest\Json\ResponseBuilder;
use Illuminate\Http\JsonResponse;
use Mockery\MockInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ResponseBuilderTest extends TestCase
{

    public function test_response_builder_return_json_response(): void
    {
        $dto = new ResponseBuilderInputDTO(
            Response::HTTP_OK,
            'Ok.'
        );

        $this->mock(ResponseContract::class, function (MockInterface $mock) {
            $mock->shouldReceive('handle')
                ->once()
                ->andReturn(new JsonResponse());
        });

        $response = app(ResponseBuilder::class)->build($dto);

        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
