<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceRepository;

class MedicalServiceBindingServiceProvider extends ServiceProvider
{
    public array $bindings = [
        MedicalServiceRepository::class => EloquentMedicalServiceRepository::class
    ];

    public function register(): void
    {
    }


    public function boot(): void
    {
    }
}
