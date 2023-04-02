<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert\Contract;

interface BlockAlertContract extends BaseAlertContract
{
    public function block(): array;
}
