<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\shared\Domain\App\ApplicationContract;
use Src\shared\Domain\Config\ConfigContract;
use Src\shared\Domain\HttpClient\Contract\HttpClientContract;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\App\LaravelApplication;
use Src\shared\Infrastructure\Config\LaravelConfig;
use Src\shared\Infrastructure\HttpClient\LaravelHttpClient;
use Src\shared\Infrastructure\Response\Rest\Json;

class SharedBindingServiceProvider extends ServiceProvider
{
    public array $bindings = [
        ApplicationContract::class => LaravelApplication::class,
        ConfigContract::class => LaravelConfig::class,
        HttpClientContract::class => LaravelHttpClient::class,
        RestResponseContract::class => Json::class,
    ];
}
