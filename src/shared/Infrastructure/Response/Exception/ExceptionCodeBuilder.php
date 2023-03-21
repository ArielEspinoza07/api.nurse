<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Response\Exception;

use Src\shared\Domain\Exception\ExceptionCode;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExceptionCodeBuilder
{
    public function build(Throwable $throwable): ExceptionCode
    {
        if (method_exists($throwable, 'getStatusCode')) {
            return ExceptionCode::create($throwable->getStatusCode());
        }
        if (property_exists($throwable, 'status')) {
            return ExceptionCode::create($throwable->status);
        }
        if ($throwable->getMessage() === 'Unauthenticated.') {
            return ExceptionCode::create(Response::HTTP_UNAUTHORIZED);
        }
        if (intval($throwable->getCode()) === 0) {
            return ExceptionCode::create(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        if ($throwable->getCode() >= 600) {
            return ExceptionCode::create(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return ExceptionCode::create($throwable->getCode());
    }
}
