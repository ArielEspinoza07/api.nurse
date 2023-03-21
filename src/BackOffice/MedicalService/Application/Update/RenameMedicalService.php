<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Update;

use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class RenameMedicalService
{
    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(
        MedicalService $medicalService,
        MedicalServiceName $name
    ): MedicalService {
        $medicalService->name()->change($name->value());
        $this->repository->update($medicalService);

        return $medicalService;
    }
}
