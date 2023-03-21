<?php

declare(strict_types=1);

namespace Src\shared\Domain\Criteria;

class Filters
{
    private function __construct(private array $values)
    {
    }

    public static function create(): self
    {
        return new static([]);
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
