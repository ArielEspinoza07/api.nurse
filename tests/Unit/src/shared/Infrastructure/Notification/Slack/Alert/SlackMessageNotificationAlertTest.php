<?php

namespace Tests\Unit\src\shared\Infrastructure\Notification\Slack\Alert;

use InvalidArgumentException;
use Mockery;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Domain\Notification\Slack\Alert\ExceptionMessageAlert;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackMessageNotificationAlert;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SlackMessageNotificationAlertTest extends TestCase
{
    public function test_slack_message_notification_alert_is_send(): void
    {
        $exceptionAlert = ExceptionMessageAlert::create(
            new InvalidArgumentException('Invalid argument name', Response::HTTP_BAD_REQUEST)
        );

        SlackAlert::shouldReceive('to')
            ->once()
            ->with(
                Mockery::on(function (string $text) use ($exceptionAlert) {
                    return $text === $exceptionAlert->to();
                })
            )
            ->andReturnSelf();

        SlackAlert::shouldReceive('message')
            ->once()
            ->with(
                Mockery::on(function (string $text) use ($exceptionAlert) {
                    return $exceptionAlert->message() === $text;
                })
            )
            ->andReturn();

        (new SlackMessageNotificationAlert())->send($exceptionAlert);
    }
}
