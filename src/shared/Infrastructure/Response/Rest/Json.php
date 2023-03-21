<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Response\Rest;

use Illuminate\Http\JsonResponse;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Domain\Response\Response;
use Src\shared\Domain\Response\ResponseCode;
use Src\shared\Infrastructure\Response\ResponseDataBuilder;
use Symfony\Component\HttpFoundation\Response as HttpCode;

class Json implements RestResponseContract
{
    public function send(
        string $message,
        array|null $data = null,
        int $code = HttpCode::HTTP_OK,
        bool $success = true
    ): JsonResponse {
        $response = Response::create(
            ResponseCode::create($code),
            (new ResponseDataBuilder())->build($message, $success, $data)
        );
        return new JsonResponse($response->data()->toArray(), $response->code()->value());
    }
}
