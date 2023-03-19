<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Delete;

use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class DeleteMedicalService
{
    private GetMedicalServiceById $getMedicalServiceById;

    public function __construct(private readonly MedicalServiceRepository $repository)
    {
        $this->getMedicalServiceById = new GetMedicalServiceById($this->repository);
    }

    public function handle(MedicalServiceId $id): void
    {
        $this->getMedicalServiceById->handle($id);
        $this->repository->delete($id);
    }
}
