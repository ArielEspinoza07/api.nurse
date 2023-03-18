<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Exception;

use Symfony\Component\HttpFoundation\Response;
use Throwable;

class GetExceptionCode
{
    public function handle(Throwable $throwable): int
    {
        if (method_exists($throwable, 'getStatusCode')) {
            return $throwable->getStatusCode();
        }
        if (property_exists($throwable, 'status')) {
            return $throwable->status;
        }
        if ($throwable->getMessage() === 'Unauthenticated.') {
            return Response::HTTP_UNAUTHORIZED;
        }
        if (intval($throwable->getCode()) === 0) {
            return Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return $throwable->getCode();
    }
}
