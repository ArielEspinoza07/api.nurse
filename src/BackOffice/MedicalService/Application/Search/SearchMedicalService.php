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
            return $this->repository->searchAll();
        }
        $paginated = $this->repository->searchByCriteria($criteria);

        return [
            'items' => $paginated['data'],
            'meta' => [
                'page' => $paginated['current_page'],
                'per_page' => $paginated['per_page'],
                'page_count' => count($paginated['data']),
                'total_count' => $paginated['total'],
                'links' => $paginated['links'],
            ],
        ];
    }
}
