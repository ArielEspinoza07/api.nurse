<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Delete\MedicalServiceDeletor;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;


class MedicalServiceDeletorTest extends MedicalServiceApplicationTestBase
{

    use RefreshDatabase;

    public function test_update_medical_service(): void
    {
        $medicalServiceData = [
            'name' => 'Intensive Care Units',
            'is_active' => true,
        ];

        $medicalServiceId = $this->createMedicalService($medicalServiceData);

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(MedicalServiceDeletor::class, $repository);

        $repository->shouldReceive('delete')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $medicalServiceId->value() === $id->value();
                })
            );

        (new MedicalServiceDeletor($repository))
            ->handle($medicalServiceId);
    }
}
