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

    public function test_update_medical_service(): void
    {
        $medicalServiceData = [
            'name' => 'Intensive Care Units',
            'is_active' => true,
        ];

        $medicalServiceId = $this->createMedicalService($medicalServiceData);

        $dataToUpdate = [
            'name' => 'Intensive Care Unit',
        ];

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(UpdateMedicalService::class, $repository);


        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $id->value() === $medicalServiceId->value();
                })
            )
            ->andReturn(
                MedicalService::create(
                    $medicalServiceId,
                    new MedicalServiceName($medicalServiceData['name']),
                    MedicalServiceIsActive::create($medicalServiceData['is_active'])
                )
            );

        $medicalServiceUpdated = MedicalService::create(
            $medicalServiceId,
            new MedicalServiceName($dataToUpdate['name']),
            MedicalServiceIsActive::create($medicalServiceData['is_active'])
        );

        $repository->shouldReceive('update')
            ->once()
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
                new MedicalServiceName($dataToUpdate['name']),
                MedicalServiceIsActive::create($medicalServiceData['is_active'])
            );

        $this->assertInstanceOf(MedicalService::class, $updated);

        $this->assertEquals($medicalServiceId->value(), $updated->id()->value());
        $this->assertEquals($dataToUpdate['name'], $updated->name()->value());
        $this->assertEquals($medicalServiceData['is_active'], $updated->active()->value());
    }
}
