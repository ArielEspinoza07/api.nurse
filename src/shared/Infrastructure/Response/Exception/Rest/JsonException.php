<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Response\Exception\Rest;

use Illuminate\Http\JsonResponse;
use Src\shared\Infrastructure\Response\Exception\ExceptionCodeBuilder;
use Src\shared\Infrastructure\Response\Exception\ExceptionDataBuilder;
use Src\shared\Infrastructure\Response\Exception\ExceptionMessageBuilder;
use Src\shared\Infrastructure\Response\Rest\Json;
use Throwable;

class JsonException
{
    public function send(Throwable $throwable): JsonResponse
    {
        return (new Json())->send(
            (new ExceptionMessageBuilder())->build($throwable)->value(),
            (new ExceptionDataBuilder())->build($throwable)->value(),
            (new ExceptionCodeBuilder())->build($throwable)->value(),
            false
        );
    }
}
