<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Update\RenameMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;


class RenameMedicalServiceTest extends MedicalServiceApplicationTestBase
{

    use RefreshDatabase;

    public function test_rename_medical_service(): void
    {
        $medicalServiceId = $this->createMedicalService('Intensive Care Units');

        $medicalService = $this->getMedicalServiceById($medicalServiceId);

        $medicalServiceUpdated = MedicalService::create(
            $medicalServiceId,
            MedicalServiceName::create('ICU'),
            MedicalServiceIsActive::createActive()
        );

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(RenameMedicalService::class, $repository);

        $repository->shouldReceive('update')
            ->once()
            ->with(
                Mockery::on(function (MedicalService $medicalService) use ($medicalServiceUpdated) {
                    return $medicalService->id()->value() === $medicalServiceUpdated->id()->value()
                        && $medicalService->name()->value() === $medicalServiceUpdated->name()->value();
                })
            )
            ->andReturn($medicalServiceUpdated);

        $updated = (new RenameMedicalService($repository))
            ->handle(
                $medicalService,
                $medicalServiceUpdated->name()
            );

        $this->assertInstanceOf(MedicalService::class, $updated);

        $this->assertEquals($medicalServiceId->value(), $updated->id()->value());
        $this->assertEquals($medicalServiceUpdated->name()->value(), $updated->name()->value());
        $this->assertEquals(true, $updated->active()->value());
    }
}
