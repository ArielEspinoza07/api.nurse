<?php

namespace Tests\Unit\src\shared\Infrastructure\Notification\Slack\Alert;

use InvalidArgumentException;
use Mockery;
use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Infrastructure\Notification\Slack\Alert\AlertWebhook;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackExceptionAlert;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SlackExceptionAlertTest extends TestCase
{
    public function test_send_slack_alert(): void
    {
        $exception = new InvalidArgumentException('Invalid argument name', Response::HTTP_BAD_REQUEST);
        $block = [
            [
                'type' => 'header',
                'text' => [
                    'type' => 'plain_text',
                    'text' => 'Exception :collision:',
                    'emoji' => true,
                ]
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => '*Type:* ' . get_class($exception),
                ]
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => '*Message:* ' . $exception->getMessage(),
                ]
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => '*File:* ' . $exception->getFile(),
                ]
            ],
            [
                'type' => 'section',
                'fields' => [
                    [
                        'type' => 'mrkdwn',
                        'text' => '*Code:* ' . $exception->getCode(),
                    ],
                    [
                        'type' => 'mrkdwn',
                        'text' => '*Line:* ' . $exception->getLine(),
                    ],
                ]
            ],
        ];

        SlackAlert::shouldReceive('to')
            ->once()
            ->with(
                Mockery::on(function (string $text) {
                    return $text === AlertWebhook::EXCEPTION;
                })
            )
            ->andReturnSelf();

        SlackAlert::shouldReceive('blocks')
            ->once()
            ->with(
                Mockery::on(function (array $blocks) use ($block) {
                    return count($block) === count($blocks);
                })
            )
            ->andReturn();

        (new SlackExceptionAlert($exception))->send();
    }
}
