<?php

namespace Tests\Unit\src\shared\Infrastructure\Notification\Slack\Alert;

use Src\shared\Domain\Notification\Slack\Alert\AlertType;
use Src\shared\Domain\Notification\Slack\Alert\Contract\AlertContract;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackBlockNotificationAlert;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackNotificationAlertFactory;
use Tests\TestCase;

class SlackNotificationAlertFactoryTest extends TestCase
{

    public function test_return_notification_alert(): void
    {
        $alert = (new SlackNotificationAlertFactory())->make(AlertType::BLOCK);

        $this->assertInstanceOf(AlertContract::class, $alert);
        $this->assertInstanceOf(SlackBlockNotificationAlert::class, $alert);
    }
}
