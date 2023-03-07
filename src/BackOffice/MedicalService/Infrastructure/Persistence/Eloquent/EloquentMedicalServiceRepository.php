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

    public function searchAll(): array
    {
        return EloquentMedicalServiceModel::all()
            ->toArray();
    }

    public function searchByCriteria(Criteria $criteria): array
    {
        return EloquentCriteriaConverter::convert(
            $criteria,
            app()->make(EloquentMedicalServiceModel::class)
        )
            ->paginate($criteria->limit())
            ->toArray();
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
