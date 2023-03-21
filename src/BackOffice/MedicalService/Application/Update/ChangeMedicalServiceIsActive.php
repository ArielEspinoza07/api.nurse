<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Update;

use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class ChangeMedicalServiceIsActive
{
    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(
        MedicalService $medicalService,
    ): MedicalService {
        $medicalService->active()->change();
        $this->repository->update($medicalService);

        return $medicalService;
    }
}
