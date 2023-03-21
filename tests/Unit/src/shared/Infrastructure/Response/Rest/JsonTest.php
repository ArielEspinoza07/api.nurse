<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Rest;

use Illuminate\Http\JsonResponse;
use Src\shared\Infrastructure\Response\Rest\Json;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class JsonTest extends TestCase
{
    public function test_return_json_response(): void
    {
        $response = (new Json())->send('Ok.');

        $this->assertInstanceOf(JsonResponse::class, $response);

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('{"success":true,"message":"Ok.","data":null}', $response->content());
    }
}
