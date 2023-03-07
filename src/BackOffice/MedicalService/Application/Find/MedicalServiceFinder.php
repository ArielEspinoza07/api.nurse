<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Find;

use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class MedicalServiceFinder
{

    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(MedicalServiceId $id): MedicalService
    {
        return $this->repository->findById($id);
    }
}
