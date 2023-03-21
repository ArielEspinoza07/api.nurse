<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Delete\DeleteMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;


class DeleteMedicalServiceTest extends MedicalServiceApplicationTestBase
{

    use RefreshDatabase;

    public function test_delete_medical_service(): void
    {
        $medicalServiceId = $this->createMedicalService('Intensive Care Units');

        $medicalService = $this->getMedicalServiceById($medicalServiceId);

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(DeleteMedicalService::class, $repository);

        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $id->value() === $medicalServiceId->value();
                })
            )
            ->andReturn($medicalService);

        $repository->shouldReceive('delete')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $medicalServiceId->value() === $id->value();
                })
            );

        (new DeleteMedicalService($repository))
            ->handle($medicalServiceId);
    }
}
