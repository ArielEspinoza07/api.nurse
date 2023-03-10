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

    public function handle(Criteria|null $criteria = null): array
    {
        if (!$criteria) {
            return $this->output($this->repository->searchAll());
        }
        $paginated = $this->repository->searchByCriteria($criteria);
        $paginated['data'] = $this->output($paginated['data']);

        return $paginated;
    }


    private function output(array $medicalServices): array
    {
        return array_map(function ($service) {
            return MedicalService::create(
                new MedicalServiceId($service['id']),
                new MedicalServiceName($service['name']),
                new MedicalServiceIsActive($service['is_active']),
            )
                ->toArray();
        }, $medicalServices);
    }
}
