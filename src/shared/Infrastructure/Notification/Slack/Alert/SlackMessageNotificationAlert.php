<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Notification\Slack\Alert;

use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Domain\Notification\Slack\Alert\Contract\AlertContract;
use Src\shared\Domain\Notification\Slack\Alert\Contract\BaseAlertContract;

class SlackMessageNotificationAlert implements AlertContract
{
    public function send(BaseAlertContract $contract): void
    {
        SlackAlert::to($contract->to())->message($contract->message());
    }
}
