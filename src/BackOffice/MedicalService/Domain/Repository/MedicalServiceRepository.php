<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Domain\Repository;

use Src\BackOffice\MedicalService\Domain\MedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\shared\Domain\Criteria\Criteria;

interface MedicalServiceRepository
{
    public function count(Criteria $criteria): int;

    public function create(MedicalServiceName $name, MedicalServiceIsActive $active): MedicalService;

    public function delete(MedicalServiceId $id): void;

    public function findById(MedicalServiceId $id): MedicalService;

    public function search(Criteria $criteria): array;

    public function update(MedicalService $medicalService): void;
}
