<?php

declare(strict_types=1);

namespace Src\shared\Domain\File;

class DomainFile
{
    private string $path;

    private function __construct(private readonly string $relativePath, private readonly string $name)
    {
        $this->path = "{$this->relativePath}\\{$this->name}";
    }

    public static function create(string $path, string $name): self
    {
        return new static($path, $name);
    }

    public function path(): string
    {
        return $this->path;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function relativePath(): string
    {
        return $this->relativePath;
    }

    public function nameContains(string $value): bool
    {
        return $this->contains($this->name, $value);
    }

    public function relativePathContains(string $value): bool
    {
        return $this->contains($this->relativePath, $value);
    }

    private function contains(string $search, string $value): bool
    {
        return str_contains($search, $value);
    }
}
