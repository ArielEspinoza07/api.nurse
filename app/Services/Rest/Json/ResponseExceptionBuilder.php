<?php

declare(strict_types=1);

namespace App\Services\Rest\Json;

use App\Services\Rest\Json\Contract\ResponseContract;
use App\Services\Rest\Json\Contract\ResponseExceptionHandlerContract;
use App\Services\Rest\Json\DTO\ResponseInputDTO;
use App\Services\Rest\Json\Exception\GetExceptionCode;
use App\Services\Rest\Json\Exception\GetExceptionData;
use App\Services\Rest\Json\Exception\GetExceptionMessage;
use Illuminate\Http\JsonResponse;
use Throwable;

class ResponseExceptionBuilder implements ResponseExceptionHandlerContract
{

    public function __construct(private readonly ResponseContract $response)
    {
    }

    public function handle(Throwable $throwable): JsonResponse
    {
        return $this->response->handle(
            ResponseInputDTO::createFromValues(
                (new GetExceptionMessage())->handle($throwable),
                (new GetExceptionCode())->handle($throwable),
                (new GetExceptionData())->handle($throwable),
                false,
            )
        );
    }
}
