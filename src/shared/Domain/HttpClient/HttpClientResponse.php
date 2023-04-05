<?php

declare(strict_types=1);

namespace Src\shared\Domain\HttpClient;

use Src\shared\Domain\HttpClient\Exception\HttpClientException;

class HttpClientResponse
{
    private function __construct(
        private readonly HttpClientResponseStatus $status,
        private readonly HttpClientResponseBody $body
    ) {
    }

    public static function create(HttpClientResponseStatus $status, HttpClientResponseBody $body): HttpClientResponse
    {
        return new static($status, $body);
    }

    public function status(): HttpClientResponseStatus
    {
        return $this->status;
    }

    public function body(): HttpClientResponseBody
    {
        return $this->body;
    }

    public function throwExceptionIfFailed(): void
    {
        if ($this->status->failed()) {
            throw new HttpClientException(
                "HTTP request returned status code {$this->status->value()}, {$this->body->value()}",
                $this->status->value()
            );
        }
    }
}
