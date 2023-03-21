<?php

namespace Tests\Unit\src\BackOffice\MedicalService\Application;

use Database\Seeders\MedicalServiceSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Src\BackOffice\MedicalService\Application\Search\SearchMedicalService;
use Src\BackOffice\MedicalService\Domain\Repository\MedicalServiceRepository;
use Src\BackOffice\MedicalService\Infrastructure\Persistence\Eloquent\EloquentMedicalServiceModel;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filter;
use Src\shared\Domain\Criteria\FilterField;
use Src\shared\Domain\Criteria\FilterOperator;
use Src\shared\Domain\Criteria\Filters;
use Src\shared\Domain\Criteria\FilterValue;
use Src\shared\Domain\Criteria\Order;
use Tests\Unit\src\BackOffice\MedicalService\MedicalServiceApplicationTestBase;

class SearchMedicalServiceTest extends MedicalServiceApplicationTestBase
{
    use RefreshDatabase;

    public function test_get_all_medical_services(): void
    {
        $this->seed(MedicalServiceSeeder::class);

        $services = EloquentMedicalServiceModel::query()
            ->where('name', 'like', '%ic%')
            ->get()->map(function (EloquentMedicalServiceModel $medicalServiceModel) {
                return [
                    'id' => $medicalServiceModel->id,
                    'name' => $medicalServiceModel->name,
                    'is_active' => $medicalServiceModel->is_active,
                ];
            })
            ->toArray();

        $filters = Filters::create();
        $filters->add(
            Filter::create(
                FilterField::create('name'),
                FilterOperator::create(FilterOperator::LIKE),
                FilterValue::create('ic'),
            )
        );
        $nameLikeICCriteria = Criteria::create(
            $filters,
            Order::createEmpty()
        );

        $repository = Mockery::mock(MedicalServiceRepository::class);
        $this->app->instance(SearchMedicalService::class, $repository);

        $repository->shouldReceive('search')
            ->once()
            ->with(
                Mockery::on(function (Criteria $criteria) use ($nameLikeICCriteria) {
                    return $criteria->hasFilters() === $criteria->hasFilters()
                        && $criteria->order()->orderBy()->value() === $nameLikeICCriteria->order()->orderBy()->value()
                        && $criteria->order()->orderType()->value() === $nameLikeICCriteria->order()->orderType()->value();
                })
            )
            ->andReturn($services);

        $search = (new SearchMedicalService($repository))
            ->handle($nameLikeICCriteria);

        $this->assertIsArray($search);
        $this->assertEquals(count($services), count($search));
    }
}
