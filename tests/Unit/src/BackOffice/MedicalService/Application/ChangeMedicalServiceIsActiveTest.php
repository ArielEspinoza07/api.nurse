<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Update\ChangeMedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;


class ChangeMedicalServiceIsActiveTest extends MedicalServiceApplicationTestBase
{

    use RefreshDatabase;

    public function test_change_medical_service_is_active(): void
    {
        $medicalServiceId = $this->createMedicalService('Intensive Care Units');

        $medicalService = $this->getMedicalServiceById($medicalServiceId);

        $medicalServiceUpdated = MedicalService::create(
            $medicalServiceId,
            $medicalService->name(),
            MedicalServiceIsActive::create(false)
        );

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(ChangeMedicalServiceIsActive::class, $repository);

        $repository->shouldReceive('update')
            ->once()
            ->with(
                Mockery::on(function (MedicalService $medicalService) use ($medicalServiceUpdated) {
                    return $medicalService->id()->value() === $medicalServiceUpdated->id()->value()
                        && $medicalService->name()->value() === $medicalServiceUpdated->name()->value();
                })
            )
            ->andReturn($medicalServiceUpdated);

        $updated = (new ChangeMedicalServiceIsActive($repository))
            ->handle($medicalService);

        $this->assertInstanceOf(MedicalService::class, $updated);

        $this->assertEquals($medicalServiceId->value(), $updated->id()->value());
        $this->assertEquals($medicalService->name()->value(), $updated->name()->value());
        $this->assertEquals(false, $updated->active()->value());
    }
}
