<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Create;

use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class MedicalServiceCreator
{

    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(MedicalServiceName $name): MedicalService
    {
        return $this->repository->create(
            $name,
            MedicalServiceIsActive::createActive()
        );
    }
}
