<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Exception;

use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Throwable;

class GetExceptionData
{
    public function handle(Throwable $throwable): array|null
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
}
