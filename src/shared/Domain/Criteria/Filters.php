<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Filters
{
    public function __construct(private array $values = [])
    {
    }

    public function add(Filter $filter): void
    {
        $this->values[] = $filter;
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function value(): array
    {
        return $this->values;
    }
}
