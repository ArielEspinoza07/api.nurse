<?php

namespace Tests\Unit\src\shared\Infrastructure\HttpClient;

use Src\shared\Domain\HttpClient\Contract\HttpClientContract;
use Src\shared\Domain\HttpClient\HttpClientResponse;
use Src\shared\Infrastructure\HttpClient\LaravelHttpClient;
use Tests\TestCase;

class LaravelHttpClientTest extends TestCase
{
    public function test_laravel_http_client_return_http_client_response(): void
    {
        $apiUrl = 'https://official-joke-api.appspot.com/random_joke';

        $httpClient = new LaravelHttpClient();

        $this->assertNotNull($httpClient);
        $this->assertInstanceOf(HttpClientContract::class, $httpClient);

        $response = $httpClient->asJson()->get($apiUrl);

        $this->assertNotNull($response);
        $this->assertInstanceOf(HttpClientResponse::class, $response);
    }
}
