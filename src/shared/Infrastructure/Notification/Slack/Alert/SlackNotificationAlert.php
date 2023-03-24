<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Notification\Slack\Alert;

use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Domain\Notification\Slack\Alert\Contract\AlertContract;
use Src\shared\Domain\Notification\Slack\Alert\Contract\BaseAlertContract;

class SlackNotificationAlert implements AlertContract
{
    public function sendBlock(BaseAlertContract $contract): void
    {
        SlackAlert::to($contract->to())->blocks($contract->block());
    }

    public function sendMessage(BaseAlertContract $contract): void
    {
        SlackAlert::to($contract->to())->message($contract->message());
    }
}
