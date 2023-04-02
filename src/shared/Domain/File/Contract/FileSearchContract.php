<?php

declare(strict_types=1);

namespace Src\shared\Domain\File\Contract;

use Src\shared\Domain\File\DomainFile;

interface FileSearchContract
{
    /**
     * @param array<DomainFile> $files
     * @param string $name
     * @param string $except
     * @return array
     */
    public function search(array $files, string $name, string $except = ''): array;
}
