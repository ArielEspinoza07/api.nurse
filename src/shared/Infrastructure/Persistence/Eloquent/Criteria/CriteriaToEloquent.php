<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Persistence\Eloquent\Criteria;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Src\shared\Domain\Criteria\Criteria;

class CriteriaToEloquent
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
        return CriteriaToQueryBuilder::create($this->criteria, $this->model)->convert();
    }
}
