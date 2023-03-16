<?php

declare(strict_types=1);

namespace App\Services\Rest\Json;

use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\DTO\ResponseInputDTO;
use Illuminate\Http\JsonResponse;

class Response implements ResponseContract
{

    public function handle(ResponseInputDTO $inputDTO): JsonResponse
    {
        return new JsonResponse($inputDTO->data, $inputDTO->code);
    }
}
