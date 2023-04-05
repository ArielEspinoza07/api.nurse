<?php

namespace Tests\Unit\src\shared\Infrastructure\App;

use Src\shared\Domain\App\ApplicationContract;
use Src\shared\Infrastructure\App\LaravelApplication;
use Tests\TestCase;

class LaravelApplicationTest extends TestCase
{
    public function test_laravel_application_return_environment(): void
    {
        $app = new LaravelApplication($this->app);

        $this->assertNotNull($app);
        $this->assertInstanceOf(ApplicationContract::class, $app);

        $this->assertIsString($app->environment());
        $this->assertEquals($this->app->environment(), $app->environment());
    }
}
