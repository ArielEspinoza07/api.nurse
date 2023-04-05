<?php

namespace Tests\Unit\src\shared\Infrastructure\Config;

use Src\shared\Domain\Config\ConfigContract;
use Src\shared\Infrastructure\Config\LaravelConfig;
use Tests\TestCase;

class LaravelConfigTest extends TestCase
{
    public function test_laravel_application_return_config(): void
    {
        $key = "services.mailtrap.{$this->app->environment()}";

        $config = new LaravelConfig(config());

        $this->assertNotNull($config);
        $this->assertInstanceOf(ConfigContract::class, $config);

        $this->assertIsArray($config->get($key));
        $this->assertCount(3, $config->get($key));
    }
}
