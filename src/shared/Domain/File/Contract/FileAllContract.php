<?php

declare(strict_types=1);

namespace Src\shared\Domain\File\Contract;

use Src\shared\Domain\File\DomainFile;

interface FileAllContract
{
    /**
     * @return array<DomainFile>
     */
    public function all(string $path): array;
}
