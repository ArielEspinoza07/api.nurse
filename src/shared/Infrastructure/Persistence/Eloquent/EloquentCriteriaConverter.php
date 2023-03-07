<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Src\shared\Domain\Criteria\Criteria;
use Src\shared\Domain\Criteria\Filter;
use Src\shared\Domain\Criteria\FilterOperator;

class EloquentCriteriaConverter
{

    public function __construct(private readonly Criteria $criteria)
    {
    }

    public static function convert(Criteria $criteria, Model|Builder $model): Model|Builder
    {
        $converter = new static($criteria);

        return $converter->convertToEloquentQueryBuilder($model);
    }

    private function convertToEloquentQueryBuilder(Model|Builder $model): Model|Builder
    {
        if ($this->criteria->hasFilters()) {
            $isFirstFilter = true;
            $model = $model::query()
                ->where(function (Builder $query) use ($isFirstFilter) {
                    foreach ($this->criteria->filters()->value() as $filter) {
                        /** @var Filter $filter */
                        if ($isFirstFilter) {
                            $this->convertFilterToQuery($query, $filter, true);

                            continue;
                        }
                        $this->convertFilterToQuery($query, $filter);
                    }
                });
        }
        if (!$this->criteria->order()->getOrderType()->isNone()) {
            $model = $model->orderBy(
                $this->criteria->order()->getOrderBy()->value(),
                $this->criteria->order()->getOrderType()->value()
            );
        }

        return $model;
    }

    private function convertFilterToQuery(Builder $query, Filter $filter, bool $and = false): void
    {
        if ($and) {
            if ($filter->operator()->value() === FilterOperator::LIKE) {
                $query->where(
                    $filter->field()->value(),
                    $filter->operator()->value(),
                    "%{$filter->value()->value()}%"
                );

                return;
            }
            $query->where(
                $filter->field()->value(),
                $filter->operator()->value(),
                $filter->value()->value()
            );

            return;
        }
        if ($filter->operator()->value() === FilterOperator::LIKE) {
            $query->orWhere(
                $filter->field()->value(),
                $filter->operator()->value(),
                "%{$filter->value()->value()}%"
            );

            return;
        }
        $query->orWhere(
            $filter->field()->value(),
            $filter->operator()->value(),
            $filter->value()->value()
        );
    }
}
