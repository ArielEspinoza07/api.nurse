<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Exception;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

class GetExceptionMessage
{
    public function handle(Throwable $throwable): string
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
