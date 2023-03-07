<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\SearchAll\MedicalServiceSearcher;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;

class MedicalServiceSearcherTest extends MedicalServiceApplicationTestBase
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
        $this->app->instance(MedicalServiceSearcher::class, $repository);

        $repository->shouldReceive('searchAll')
            ->once()
            ->withNoArgs()
            ->andReturn();

        $all = (new MedicalServiceSearcher($repository))
            ->handle();

        $this->assertIsArray($all);
    }
}
