<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Rest;

use Src\shared\Domain\Response\ResponseData;
use Src\shared\Domain\Response\ResponseMessage;
use Src\shared\Domain\Response\ResponseSuccess;
use Src\shared\Infrastructure\Response\Rest\ResponseDataBuilder;
use Tests\TestCase;

class ResponseDataBuilderTest extends TestCase
{
    public function test_return_response_data(): void
    {
        $message = 'Ok.';
        $responseData = (new ResponseDataBuilder())->build($message, true);

        $this->assertInstanceOf(ResponseData::class, $responseData);
        $this->assertInstanceOf(ResponseMessage::class, $responseData->message());
        $this->assertInstanceOf(ResponseSuccess::class, $responseData->success());

        $this->assertEquals($message, $responseData->message()->value());
        $this->assertEquals(true, $responseData->success()->value());
    }
}
