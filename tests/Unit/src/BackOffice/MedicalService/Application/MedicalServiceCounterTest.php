<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Count\MedicalServiceCounter;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\Order;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;

class MedicalServiceCounterTest extends MedicalServiceApplicationTestBase
{
    use RefreshDatabase;

    public function test_count_medical_services(): void
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
        $this->app->instance(MedicalServiceCounter::class, $repository);

        $criteria = new Criteria(
            new Filters([]),
            Order::none(),
            1,
            2
        );

        $repository->shouldReceive('count')
            ->once()
            ->with($criteria)
            ->andReturn(count($services));

        $counter = (new MedicalServiceCounter($repository))
            ->handle($criteria);

        $this->assertIsInt($counter);
        $this->assertEquals(count($services), $counter);
    }
}
