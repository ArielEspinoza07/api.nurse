<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent;

use Src\BackOffice\MedicalService\Domain\Exception\MedicalServiceNotFoundException;
use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Infrastructure\Persistence\Eloquent\EloquentCriteriaConverter;

class EloquentMedicalServiceRepository implements MedicalServiceRepository
{
    public function count(Criteria $criteria): int
    {
        return EloquentCriteriaConverter::convert(
            $criteria,
            app()->make(EloquentMedicalServiceModel::class)
        )
            ->count();
    }

    public function create(MedicalServiceName $name, MedicalServiceIsActive $active): MedicalService
    {
        $model = EloquentMedicalServiceModel::query()
            ->create([
                'name' => $name->value(),
                'is_active' => $active->value(),
            ]);

        return $this->createDomainEntityFromEloquentModel($model);
    }

    public function delete(MedicalServiceId $id): void
    {
        $model = $this->findByIdOrFail($id);
        $model->delete();
    }

    public function findById(MedicalServiceId $id): MedicalService
    {
        $model = $this->findByIdOrFail($id);

        return $this->createDomainEntityFromEloquentModel($model);
    }

    public function search(Criteria $criteria): array
    {
        $results = EloquentCriteriaConverter::convert(
            $criteria,
            app()->make(EloquentMedicalServiceModel::class)
        );

        if (!$criteria->hasFilters() && $criteria->order()->orderType()->isNone()) {
            return $results->get()
                ->map(function (EloquentMedicalServiceModel $model) {
                    return MedicalService::create(
                        new MedicalServiceId($model->id),
                        new MedicalServiceName($model->name),
                        new MedicalServiceIsActive($model->is_active),
                    )->toArray();
                })
                ->toArray();
        }

        $paginatedResults = $results
            ->paginate($criteria->limit())
            ->toArray();

        return [
            'items' => array_map(function ($service) {
                return MedicalService::create(
                    new MedicalServiceId($service['id']),
                    new MedicalServiceName($service['name']),
                    new MedicalServiceIsActive($service['is_active']),
                )->toArray();
            }, $paginatedResults['data']),
            'meta' => [
                'page' => $paginatedResults['current_page'],
                'per_page' => $paginatedResults['per_page'],
                'page_count' => count($paginatedResults['data']),
                'total_count' => $paginatedResults['total'],
                'links' => $paginatedResults['links'],
            ],
        ];
    }

    public function update(MedicalService $medicalService): MedicalService
    {
        $model = $this->findByIdOrFail($medicalService->id());
        $model->update(
            [
                'name' => $medicalService->name()->value(),
                'is_active' => $medicalService->active()->value(),
            ]
        );

        return $this->createDomainEntityFromEloquentModel($model);
    }

    private function createDomainEntityFromEloquentModel(EloquentMedicalServiceModel $model): MedicalService
    {
        return MedicalService::create(
            new MedicalServiceId($model->id),
            new MedicalServiceName($model->name),
            new MedicalServiceIsActive($model->is_active)
        );
    }

    private function findByIdOrFail(MedicalServiceId $id): EloquentMedicalServiceModel|null
    {
        $model = EloquentMedicalServiceModel::query()
            ->find($id->value());

        if (!$model) {
            throw new MedicalServiceNotFoundException();
        }

        return $model;
    }
}
