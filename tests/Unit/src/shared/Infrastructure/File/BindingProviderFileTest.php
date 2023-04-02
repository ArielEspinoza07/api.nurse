<?php

namespace Tests\Unit\src\shared\Infrastructure\File;

use Src\shared\Infrastructure\File\BindingProviderFile;
use Tests\TestCase;

class BindingProviderFileTest extends TestCase
{
    public function test_all_binding_providers_files(): void
    {
        $files = (new BindingProviderFile())->all(base_path('src'));

        $this->assertNotNull($files);
        $this->assertIsArray($files);
        $this->assertNotEmpty($files);
        $this->assertGreaterThan(0, count($files));
    }

    public function test_search_binding_providers_files(): void
    {
        $bindingProviderFile = (new BindingProviderFile());
        $foundedFiles = $bindingProviderFile->search(
            $bindingProviderFile->all(base_path('src')),
            'Providers',
            'Register'
        );

        $this->assertNotNull($foundedFiles);
        $this->assertIsArray($foundedFiles);
        $this->assertNotEmpty($foundedFiles);
        $this->assertGreaterThan(0, count($foundedFiles));
    }
}
