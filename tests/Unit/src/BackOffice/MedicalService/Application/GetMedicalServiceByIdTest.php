<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\Exception\MedicalServiceNotFoundException;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;


class GetMedicalServiceByIdTest extends MedicalServiceApplicationTestBase
{

    use RefreshDatabase;

    public function test_get_medical_service_by_id(): void
    {
        $medicalServiceId = $this->createMedicalService('Intensive Care Units');

        $medicalService = $this->getMedicalServiceById($medicalServiceId);


        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(GetMedicalServiceById::class, $repository);


        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $id->value() === $medicalServiceId->value();
                })
            )
            ->andReturn($medicalService);

        $found = (new GetMedicalServiceById($repository))
            ->handle($medicalServiceId);

        $this->assertInstanceOf(MedicalService::class, $found);

        $this->assertEquals($medicalServiceId->value(), $found->id()->value());
        $this->assertEquals($medicalService->name()->value(), $found->name()->value());
        $this->assertEquals($medicalService->active()->value(), $found->active()->value());
    }

    public function test_get_medical_service_by_id_throw_exception(): void
    {
        $medicalServiceId = MedicalServiceId::random();

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(GetMedicalServiceById::class, $repository);


        $repository->shouldReceive('findById')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceId $id) use ($medicalServiceId) {
                    return $id->value() === $medicalServiceId->value();
                })
            )
            ->andThrow(new MedicalServiceNotFoundException());

        $this->expectException(MedicalServiceNotFoundException::class);

        (new GetMedicalServiceById($repository))
            ->handle($medicalServiceId);
    }
}
