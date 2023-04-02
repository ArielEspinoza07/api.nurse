<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\shared\Infrastructure\File\BindingProviderFile;

class SharedRegisterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $bindingProviderFile = (new BindingProviderFile());
        $bindingProviderFiles = $bindingProviderFile->search(
            $bindingProviderFile->all(base_path('src')),
            'Providers',
            'Register'
        );
        foreach ($bindingProviderFiles as $file) {
            $file = strtr("Src\\{$file}", ['.php' => '']);
            $this->app->register($file);
        }
    }
}
