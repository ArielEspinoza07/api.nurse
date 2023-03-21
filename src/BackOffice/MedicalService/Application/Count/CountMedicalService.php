<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Count;

use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\shared\Domain\Criteria\Criteria;

class CountMedicalService
{
    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(Criteria $criteria): array
    {
        return [
            'total' => $this->repository->count($criteria),
        ];
    }
}
