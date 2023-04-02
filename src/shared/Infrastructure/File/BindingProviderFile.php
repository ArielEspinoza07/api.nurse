<?php

namespace Src\shared\Infrastructure\File;

use Src\shared\Domain\File\Contract\FileSearchContract;
use Src\shared\Domain\File\DomainFile;

class BindingProviderFile extends BaseFile implements FileSearchContract
{
    public function search(array $files, string $name, string $except = ''): array
    {
        $filesFounded = array_map(function (DomainFile $file) use ($name, $except) {
            if ($file->relativePathContains($name) && !$file->nameContains($except)) {
                return $file->path();
            }
            return null;
        }, $files);

        return array_filter($filesFounded);
    }
}
