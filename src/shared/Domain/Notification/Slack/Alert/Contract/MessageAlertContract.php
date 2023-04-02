<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert\Contract;

interface MessageAlertContract extends BaseAlertContract
{
    public function message(): string;
}
