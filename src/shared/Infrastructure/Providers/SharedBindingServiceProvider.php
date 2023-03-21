<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Response\Rest\Json;

class SharedBindingServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RestResponseContract::class => Json::class
    ];
}
