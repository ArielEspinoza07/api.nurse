<?php

namespace Tests\Unit\src\shared\Infrastructure\Token;

use Src\shared\Infrastructure\Token\PlainTextToken;
use Tests\TestCase;

class PlainTextTokenTest extends TestCase
{
    public function test_plain_text_token_is_generate(): void
    {
        $token = (new PlainTextToken())->generate();

        $this->assertNotNull($token);
        $this->assertIsString($token);
        $this->assertEquals(PlainTextToken::TOKEN_LENGTH, strlen($token));
    }
}
