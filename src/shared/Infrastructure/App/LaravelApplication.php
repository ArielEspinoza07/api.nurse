<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\App;

use Illuminate\Contracts\Container\Container;
use Src\shared\Domain\App\ApplicationContract;

class LaravelApplication implements ApplicationContract
{
    public function __construct(private readonly Container $app)
    {
    }

    public function environment(): string
    {
        return $this->app->environment();
    }
}
