<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Token;

use Illuminate\Support\Str;
use Src\shared\Domain\Token\TokenContract;

class PlainTextToken implements TokenContract
{
    public const TOKEN_LENGTH = 40;

    public function generate(): string
    {
        return Str::random(self::TOKEN_LENGTH);
    }
}
