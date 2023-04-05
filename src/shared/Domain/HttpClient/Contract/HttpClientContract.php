<?php

declare(strict_types=1);

namespace Src\shared\Domain\HttpClient\Contract;

use Src\shared\Domain\HttpClient\HttpClientResponse;

interface HttpClientContract
{
    public function addHeader(string $key, string $value): HttpClientContract;

    public function withToken(string $token, string $type = 'Bearer'): HttpClientContract;

    public function asJson(): HttpClientContract;

    public function contentType(string $contentType): HttpClientContract;

    public function get(string $url, array|string|null $query = null): HttpClientResponse;

    public function post(string $url, array $data = []): HttpClientResponse;

    public function send(string $method, string $url, array $options = []): HttpClientResponse;
}
