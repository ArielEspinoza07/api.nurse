<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Create\CreateMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Tests\TestCase;

class MedicalServiceCreatorTest extends TestCase
{

    use RefreshDatabase;

    public function test_create_medical_service(): void
    {
        $medicalServiceName = new MedicalServiceName('Intensive Care Unit');

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(CreateMedicalService::class, $repository);

        $medicalServiceCreated = MedicalService::createFromName($medicalServiceName);

        $repository->shouldReceive('create')
            ->once()
            ->with(
                Mockery::on(function (MedicalServiceName $name) use ($medicalServiceCreated) {
                    return $name->value() === $medicalServiceCreated->name()->value();
                }),
                Mockery::on(function (MedicalServiceIsActive $active) use ($medicalServiceCreated) {
                    return $active->value() === $medicalServiceCreated->active()->value();
                }),
            )
            ->andReturn($medicalServiceCreated);

        $created = (new CreateMedicalService($repository))
            ->handle($medicalServiceName);

        $this->assertInstanceOf(MedicalService::class, $created);

        $this->assertEquals($medicalServiceName->value(), $created->name()->value());
    }
}
