<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Search\SearchMedicalService;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\Order;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;

class SearchMedicalServiceTest extends MedicalServiceApplicationTestBase
{
    use RefreshDatabase;

    public function test_get_all_medical_services(): void
    {
        $services = [
            [
                'name' => 'Emergency',
            ],
            [
                'name' => 'Geriatric',
            ],
            [
                'name' => 'Intensive Care Unit',
            ],
            [
                'name' => 'Orthopaedic ',
            ],
            [
                'name' => 'Pediatrics',
            ],
        ];

        collect($services)->each(function ($service) {
            $this->createMedicalService($service);
        });

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(SearchMedicalService::class, $repository);

        $repository->shouldReceive('searchAll')
            ->once()
            ->withNoArgs()
            ->andReturn();

        $criteria = new Criteria(
            new Filters(),
            Order::none()
        );

        $all = (new SearchMedicalService($repository))
            ->handle($criteria);

        $this->assertIsArray($all);
    }
}
