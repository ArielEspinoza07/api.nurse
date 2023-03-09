<?php

namespace Tests\Unit\src\BackOffice\MedicalService;

use Src\BackOffice\MedicalService\Application\Create\CreateMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceRepository;
use Tests\TestCase;

class MedicalServiceApplicationTestBase extends TestCase
{


    protected function createMedicalService(array $data): MedicalServiceId
    {
        $service = (new CreateMedicalService(new EloquentMedicalServiceRepository()))
            ->handle(new MedicalServiceName($data['name']));

        return $service->id();
    }
}
