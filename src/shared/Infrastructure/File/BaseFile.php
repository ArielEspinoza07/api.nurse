<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\File;

use Illuminate\Support\Facades\File;
use Src\shared\Domain\File\Contract\FileAllContract;
use Src\shared\Domain\File\DomainFile;
use Symfony\Component\Finder\SplFileInfo as FileInfo;

abstract class BaseFile implements FileAllContract
{
    public function all(string $path): array
    {
        return array_map(function (FileInfo $file) {
            return DomainFile::create(
                $file->getRelativePath(),
                $file->getBasename()
            );
        }, File::allFiles($path));
    }
}
