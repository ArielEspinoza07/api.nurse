<?php

namespace App\Services\File;

use Illuminate\Support\Facades\File;
use Symfony\Component\Finder\SplFileInfo as RouteFile;

class GetAllRouteFilesFromPath
{
    public function execute(string $path): array
    {
        return array_map(function (RouteFile $file) {
            return $file->getBasename();
        }, File::allFiles($path));
    }
}
