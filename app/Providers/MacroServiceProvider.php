<?php

namespace App\Providers;

use App\Macros\Collection\Paginate;
use App\Macros\Request\Company;
use App\Macros\TestResponse\AssertResource;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('paginate', app(Paginate::class)());
    }
}
