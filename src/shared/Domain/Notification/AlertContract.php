<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification;

interface AlertContract
{
    public function send(): void;
}
