<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Update;

use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class UpdateMedicalService
{
    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(
        MedicalServiceId $id,
        MedicalServiceName $name,
        MedicalServiceIsActive $active
    ): MedicalService {
        $medicalService = $this->repository
            ->findById($id);

        $medicalService->rename($name);

        if ($medicalService->active()->value() !== $active->value()) {
            $medicalService->toggleStatus();
        }

        return $this->repository
            ->update($medicalService);
    }
}
