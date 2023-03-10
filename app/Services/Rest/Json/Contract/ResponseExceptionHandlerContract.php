<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Contract;

use Illuminate\Http\JsonResponse;
use Throwable;

interface ResponseExceptionHandlerContract
{
    public function handle(Throwable $throwable): JsonResponse;
}
