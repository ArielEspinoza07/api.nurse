<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Criteria\DTO;

use Illuminate\Http\Request;

class SearchByCriteriaInputDTO
{
    public function __construct(
        public readonly string|null $filters,
        public readonly array|string|null $order,
        public readonly int $page,
        public readonly int $limit,
    ) {
    }

    public static function createFromRequest(Request $request): self
    {
        return new static(
            $request->get('filters'),
            $request->get('order'),
            intval($request->get('page')),
            intval($request->get('limit')),
        );
    }
}
