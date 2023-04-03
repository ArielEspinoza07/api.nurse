<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Update;

use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class UpdateMedicalService
{
    private GetMedicalServiceById $getMedicalServiceById;

    public function __construct(private readonly MedicalServiceRepository $repository)
    {
        $this->getMedicalServiceById = new GetMedicalServiceById($this->repository);
    }

    public function handle(
        MedicalServiceId $id,
        MedicalServiceName|null $name,
        MedicalServiceIsActive|null $active
    ): MedicalService {
        $medicalService = $this->getMedicalServiceById->handle($id);

        if (!is_null($name) && !$medicalService->name()->isEquals($name)) {
            $medicalService = (new RenameMedicalService($this->repository))->handle($medicalService, $name);
        }

        if (!is_null($active) && !$medicalService->active()->isEquals($active)) {
            $medicalService = (new ChangeMedicalServiceIsActive($this->repository))->handle($medicalService, $active);
        }

        return $medicalService;
    }
}
