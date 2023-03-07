<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Delete;

use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;

class MedicalServiceDeletor
{

    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(
        MedicalServiceId $id
    ) {
        $this->repository
            ->delete($id);
    }
}
