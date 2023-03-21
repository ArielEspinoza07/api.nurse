<?php

namespace App\Macros\Collection;

use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * Paginate the given collection.
 *
 * @param int $perPage
 * @param int $total
 * @param int $page
 * @param string $pageName
 *
 * @mixin Collection
 *
 * @return LengthAwarePaginator
 */
class Paginate
{
    public function __invoke(): Closure
    {
        return function (
            int $perPage = 15,
            string $pageName = 'page',
            int $page = null,
            int $total = null,
            array $options = []
        ): LengthAwarePaginator {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            $results = $this->forPage($page, $perPage)->values();

            $total = $total ?: $this->count();

            $options += [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ];

            return new LengthAwarePaginator($results, $total, $perPage, $page, $options);
        };
    }
}
