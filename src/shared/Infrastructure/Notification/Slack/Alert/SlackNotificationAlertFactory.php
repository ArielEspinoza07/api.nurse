<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Notification\Slack\Alert;

use Src\shared\Domain\Notification\Slack\Alert\AlertType;
use Src\shared\Domain\Notification\Slack\Alert\Contract\AlertContract;
use Src\shared\Domain\Validation\AssertIsBetweenAcceptedValues;

class SlackNotificationAlertFactory
{
    use AssertIsBetweenAcceptedValues;

    private array $notificationsAlert = [
        AlertType::BLOCK => SlackBlockNotificationAlert::class,
        AlertType::MESSAGE => SlackMessageNotificationAlert::class,
    ];

    public function make(string $type): AlertContract
    {
        $this->assertIsBetweenAcceptedValues($type, AlertType::toArray());

        return new $this->notificationsAlert[$type]();
    }
}
