<?php

declare(strict_types=1);

namespace Src\shared\Domain\HttpClient\Exception;

use RuntimeException;

class HttpClientException extends RuntimeException
{
    public function __construct(string $message, int|null $code = null)
    {
        parent::__construct(
            sprintf('HttpClientException: %s', $message),
            $code ?? 500
        );
    }
}
