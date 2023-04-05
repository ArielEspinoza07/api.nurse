<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Config;

use Illuminate\Contracts\Config\Repository;
use Src\shared\Domain\Config\ConfigContract;

class LaravelConfig implements ConfigContract
{
    public function __construct(private readonly Repository $config)
    {
    }

    public function get(string $key, $default = null): array|string|null
    {
        return $this->config->get($key, $default);
    }

    public function has(string $key): bool
    {
        return $this->config->has($key);
    }
}
