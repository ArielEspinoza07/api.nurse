<?php

declare(strict_types=1);

namespace Src\shared\Domain\Token;

interface TokenContract
{
    public function generate(): string;
}
