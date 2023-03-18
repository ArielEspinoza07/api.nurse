<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Database\Seeders\MedicalServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Count\CountMedicalService;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceModel;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\Order;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;

class CountMedicalServiceTest extends MedicalServiceApplicationTestBase
{
    use RefreshDatabase;

    public function test_count_medical_services(): void
    {
        $this->seed(MedicalServiceSeeder::class);

        $totalServices = EloquentMedicalServiceModel::query()
            ->count();

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(CountMedicalService::class, $repository);

        $emptyCriteria = new Criteria(
            new Filters(),
            Order::none()
        );

        $repository->shouldReceive('count')
            ->once()
            ->with(
                Mockery::on(function (Criteria $criteria) use ($emptyCriteria) {
                    return $criteria->hasFilters() === $criteria->hasFilters()
                        && $criteria->order()->orderBy()->value() === $emptyCriteria->order()->orderBy()->value()
                        && $criteria->order()->orderType()->value() === $emptyCriteria->order()->orderType()->value();
                })
            )
            ->andReturn($totalServices);

        $counter = (new CountMedicalService($repository))
            ->handle($emptyCriteria);

        $this->assertIsInt($counter);
        $this->assertEquals($totalServices, $counter);
    }
}
