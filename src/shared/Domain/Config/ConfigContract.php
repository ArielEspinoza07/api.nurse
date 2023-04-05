<?php

declare(strict_types=1);

namespace Src\shared\Domain\Config;

interface ConfigContract
{
    public function get(string $key, $default = null): array|string|null;

    public function has(string $key): bool;
}
