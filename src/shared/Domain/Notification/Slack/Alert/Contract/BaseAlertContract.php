<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert\Contract;

interface BaseAlertContract
{
    public function to(): string;
}
