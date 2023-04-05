<?php

declare(strict_types=1);

namespace Src\shared\Domain\App;

interface ApplicationContract
{
    public function environment(): string;
}
