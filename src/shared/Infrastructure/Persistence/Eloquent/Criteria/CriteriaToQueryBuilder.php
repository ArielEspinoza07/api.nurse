<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Persistence\Eloquent\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filter;

class CriteriaToQueryBuilder
{
    private function __construct(private readonly Criteria $criteria, private Model|Builder $model)
    {
    }

    public static function create(Criteria $criteria, Model|Builder $model): self
    {
        return new static($criteria, $model);
    }

    public function convert(): Model|Builder
    {
        if ($this->criteria->hasFilters()) {
            $isFirstFilter = true;
            $this->model = $this->model::query()
                ->where(function (Builder $query) use ($isFirstFilter) {
                    foreach ($this->criteria->filters()->value() as $filter) {
                        /** @var Filter $filter */
                        if ($isFirstFilter) {
                            FilterToQuery::create($query, $filter, true)->convert();

                            continue;
                        }
                        FilterToQuery::createFromQueryAndFilter($query, $filter)->convert();
                    }
                });
        }
        if (!$this->criteria->order()->orderType()->isNone()) {
            $this->model = $this->model->orderBy(
                $this->criteria->order()->orderBy()->value(),
                $this->criteria->order()->orderType()->value()
            );
        }

        return $this->model;
    }
}
