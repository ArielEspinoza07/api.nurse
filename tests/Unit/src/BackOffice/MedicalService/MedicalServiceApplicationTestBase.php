<?php

namespace Tests\Unit\src\BackOffice\MedicalService;

use Src\BackOffice\MedicalService\Application\Create\CreateMedicalService;
use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceRepository;
use Tests\TestCase;

class MedicalServiceApplicationTestBase extends TestCase
{


    protected function createMedicalService(string $name): MedicalServiceId
    {
        $service = (new CreateMedicalService(new EloquentMedicalServiceRepository()))
            ->handle(MedicalServiceName::create($name));

        return $service->id();
    }

    protected function getMedicalServiceById(MedicalServiceId $id): MedicalService
    {
        return (new GetMedicalServiceById(new EloquentMedicalServiceRepository()))->handle($id);
    }
}
