<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Update\UpdateMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;


class UpdateMedicalServiceTest extends MedicalServiceApplicationTestBase
{

    use RefreshDatabase;

    public function test_update_name_medical_service(): void
    {
        $medicalServiceId = $this->createMedicalService('Intensive Care Units');

        $medicalService = $this->getMedicalServiceById($medicalServiceId);

        $medicalServiceUpdated = MedicalService::create(
            $medicalServiceId,
            MedicalServiceName::create('ICU'),
            MedicalServiceIsActive::create(false)
        );

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(UpdateMedicalService::class, $repository);

        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $id->value() === $medicalServiceId->value();
                })
            )
            ->andReturn($medicalService);

        $repository->shouldReceive('update')
            ->twice()
            ->with(
                Mockery::on(function (MedicalService $medicalService) use ($medicalServiceUpdated) {
                    return $medicalService->id()->value() === $medicalServiceUpdated->id()->value()
                        && $medicalService->name()->value() === $medicalServiceUpdated->name()->value();
                })
            )
            ->andReturn($medicalServiceUpdated);

        $updated = (new UpdateMedicalService($repository))
            ->handle(
                $medicalServiceId,
                $medicalServiceUpdated->name(),
                $medicalServiceUpdated->active()
            );

        $this->assertInstanceOf(MedicalService::class, $updated);

        $this->assertEquals($medicalServiceId->value(), $updated->id()->value());
        $this->assertEquals($medicalServiceUpdated->name()->value(), $updated->name()->value());
        $this->assertEquals($medicalServiceUpdated->active()->value(), $updated->active()->value());
    }
}
