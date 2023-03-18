<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Application\Search;

use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\shared\Domain\Criteria\Criteria;

class SearchMedicalService
{
    public function __construct(private readonly MedicalServiceRepository $repository)
    {
    }

    public function handle(Criteria $criteria): array
    {
        return $this->repository->search($criteria);
    }
}
