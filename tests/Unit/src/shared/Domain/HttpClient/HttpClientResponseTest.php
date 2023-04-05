<?php

namespace Tests\Unit\src\shared\Domain\HttpClient;

use Src\shared\Domain\HttpClient\Exception\HttpClientException;
use Src\shared\Domain\HttpClient\HttpClientResponse;
use Src\shared\Domain\HttpClient\HttpClientResponseBody;
use Src\shared\Domain\HttpClient\HttpClientResponseStatus;
use Tests\TestCase;

class HttpClientResponseTest extends TestCase
{
    public function test_return_http_client_response(): void
    {
        $status = 200;
        $body = '{"success":true,"message_ids":["3382240670"]}';

        $httpClientResponse = HttpClientResponse::create(
            HttpClientResponseStatus::create($status),
            HttpClientResponseBody::create($body)
        );

        $this->assertNotNull($httpClientResponse);
        $this->assertInstanceOf(HttpClientResponse::class, $httpClientResponse);
        $this->assertNotNull($httpClientResponse->status());
        $this->assertInstanceOf(HttpClientResponseStatus::class, $httpClientResponse->status());
        $this->assertNotNull($httpClientResponse->body());
        $this->assertInstanceOf(HttpClientResponseBody::class, $httpClientResponse->body());

        $this->assertEquals($status, $httpClientResponse->status()->value());
        $this->assertTrue($httpClientResponse->status()->successful());
        $this->assertFalse($httpClientResponse->status()->failed());
        $this->assertFalse($httpClientResponse->status()->redirect());

        $this->assertEquals($body, $httpClientResponse->body()->value());
        $this->assertIsString($httpClientResponse->body()->value());
        $this->assertIsArray($httpClientResponse->body()->toArray());
        $this->assertIsObject($httpClientResponse->body()->object());
    }

    public function test_return_http_client_response_throws_exception(): void
    {
        $this->expectException(HttpClientException::class);

        $status = 507;
        $body = '{"success":false,"errors":["Insufficient Storage"]';

        $httpClientResponse = HttpClientResponse::create(
            HttpClientResponseStatus::create($status),
            HttpClientResponseBody::create($body)
        );

        $httpClientResponse->throwExceptionIfFailed();
    }
}
