<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Count;

use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\shared\Domain\Criteria\Criteria;

class MedicalServiceCounter
{
    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(Criteria $criteria): int
    {
        return $this->repository->count($criteria);
    }
}
