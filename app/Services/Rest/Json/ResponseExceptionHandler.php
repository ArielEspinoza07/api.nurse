<?php

declare(strict_types=1);

namespace App\Services\Rest\Json;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\Contract\ResponseExceptionHandlerContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use \Symfony\Component\HttpFoundation\Response as HttpResponse;
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
                $this->message($throwable),
                $this->data($throwable),
                $this->code($throwable),
                false,
            )
        );
    }

    private function code(Throwable $throwable): int
    {
        if (method_exists($throwable, 'getStatusCode')) {
            return $throwable->getStatusCode();
        }
        if (property_exists($throwable, 'status')) {
            return $throwable->status;
        }
        if (intval($throwable->getCode()) === 0) {
            return HttpResponse::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $throwable->getCode();
    }

    private function data(Throwable $throwable): array|null
    {
        if (method_exists($throwable, 'getMessageBag')) {
            return $throwable
                ->getMessageBag()
                ->getMessages();
        }
        if (property_exists($throwable, 'validator')) {
            return $throwable
                ->validator
                ->errors()
                ->getMessages();
        }

        return null;
    }

    private function message(Throwable $throwable): string
    {
        if (method_exists($throwable, 'statustext')) {
            return $throwable->statustext();
        }
        if (!empty($throwable->getMessage())) {
            return $throwable->getMessage();
        }

        return 'Internal Server Error';
    }
}
