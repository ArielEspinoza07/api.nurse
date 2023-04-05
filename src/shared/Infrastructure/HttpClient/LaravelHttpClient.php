<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\HttpClient;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Src\shared\Domain\HttpClient\Contract\HttpClientContract;
use Src\shared\Domain\HttpClient\HttpClientResponse;
use Src\shared\Domain\HttpClient\HttpClientResponseBody;
use Src\shared\Domain\HttpClient\HttpClientResponseStatus;

class LaravelHttpClient implements HttpClientContract
{
    private PendingRequest $client;

    public function __construct()
    {
        $this->client = new PendingRequest();
    }

    public function addHeader(string $key, string $value): HttpClientContract
    {
        $this->client->withHeaders([$key => $value]);

        return $this;
    }

    public function withToken(string $token, string $type = 'Bearer'): HttpClientContract
    {
        $this->client->withHeaders(['Authorization' => trim($type . ' ' . $token)]);

        return $this;
    }

    public function asJson(): HttpClientContract
    {
        $this->client->withHeaders(['Content-Type' => 'application/json']);

        return $this;
    }

    public function contentType(string $contentType): HttpClientContract
    {
        $this->client->withHeaders(['Content-Type' => $contentType]);

        return $this;
    }

    public function get(string $url, array|string|null $query = null): HttpClientResponse
    {
        $response = collect([$this->client->get($url, $query)])
            ->map($this->toHttpClientResponse())
            ->first();
        $response->throwExceptionIfFailed();

        return $response;
    }

    public function post(string $url, array $data = []): HttpClientResponse
    {
        $response = collect([$this->client->post($url, $data)])
            ->map($this->toHttpClientResponse())
            ->first();
        $response->throwExceptionIfFailed();

        return $response;
    }

    public function send(string $method, string $url, array $options = []): HttpClientResponse
    {
        $response = collect([$this->client->send($method, $url, $options)])
            ->map($this->toHttpClientResponse())
            ->first();
        $response->throwExceptionIfFailed();

        return $response;
    }

    private function toHttpClientResponse(): callable
    {
        return static fn(Response $response) => HttpClientResponse::create(
            HttpClientResponseStatus::create($response->status()),
            HttpClientResponseBody::create($response->body())
        );
    }
}
