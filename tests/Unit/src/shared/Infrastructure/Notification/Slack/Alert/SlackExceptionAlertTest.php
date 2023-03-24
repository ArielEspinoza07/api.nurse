<?php

namespace Tests\Unit\src\shared\Infrastructure\Notification\Slack\Alert;

use InvalidArgumentException;
use Mockery;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Domain\Notification\Slack\Alert\ExceptionAlert;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackNotificationAlert;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SlackExceptionAlertTest extends TestCase
{
    public function test_send_slack_alert_block(): void
    {
        $exceptionAlert = ExceptionAlert::create(
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

        (new SlackNotificationAlert())->sendBlock($exceptionAlert);
    }
}
