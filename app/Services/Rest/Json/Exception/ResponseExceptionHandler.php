<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Exception;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\Contract\ResponseExceptionHandlerContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Throwable;

class ResponseExceptionHandler implements ResponseExceptionHandlerContract
{

    public function __construct(private readonly ResponseBuilderContract $responseBuilder)
    {
    }

    public function handle(Throwable $throwable): JsonResponse
    {
        return $this->responseBuilder->build(
            new ResponseBuilderInputDTO(
                (new GetExceptionMessage())->handle($throwable),
                (new GetExceptionData())->handle($throwable),
                (new GetExceptionCode())->handle($throwable),
                false,
            )
        );
    }
}
