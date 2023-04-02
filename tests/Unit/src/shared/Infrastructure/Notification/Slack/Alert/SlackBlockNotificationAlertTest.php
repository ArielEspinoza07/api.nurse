<?php

namespace Tests\Unit\src\shared\Infrastructure\Notification\Slack\Alert;

use InvalidArgumentException;
use Mockery;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Domain\Notification\Slack\Alert\ExceptionBlockAlert;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackBlockNotificationAlert;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SlackBlockNotificationAlertTest extends TestCase
{
    public function test_slack_block_notification_alert_is_send(): void
    {
        $exceptionAlert = ExceptionBlockAlert::create(
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

        SlackAlert::shouldReceive('blocks')
            ->once()
            ->with(
                Mockery::on(function (array $blocks) use ($exceptionAlert) {
                    return count($exceptionAlert->block()) === count($blocks);
                })
            )
            ->andReturn();

        (new SlackBlockNotificationAlert())->send($exceptionAlert);
    }
}
