<?php

declare(strict_types=1);

namespace App\Services\Rest\Json;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use App\Services\Rest\Json\DTO\ResponseInputDTO;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseBuilder implements ResponseBuilderContract
{

    public function __construct(
        private readonly ResponseContract $response
    ) {
    }

    public function build(ResponseBuilderInputDTO $inputDTO): JsonResponse
    {
        return $this->response->handle(
            new ResponseInputDTO(
                $inputDTO->code,
                [
                    'success' => $inputDTO->success,
                    'message' => $inputDTO->message,
                    'data' => $inputDTO->data
                ]
            )
        );
    }

}
