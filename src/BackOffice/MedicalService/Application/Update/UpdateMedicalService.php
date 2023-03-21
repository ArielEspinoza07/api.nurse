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
        MedicalServiceName $name,
        MedicalServiceIsActive $active
    ): MedicalService {
        $medicalService = $this->getMedicalServiceById->handle($id);

        if ($medicalService->name()->value() !== $name->value()) {
            $medicalService->name()->change($name->value());
        }

        if ($medicalService->active()->value() !== $active->value()) {
            $medicalService->active()->change();
        }

        $this->repository->update($medicalService);

        return $medicalService;
    }
}
