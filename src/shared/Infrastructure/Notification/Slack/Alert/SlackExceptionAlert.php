<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Notification\Slack\Alert;

use Spatie\SlackAlerts\Facades\SlackAlert;
use Src\shared\Domain\Notification\AlertContract;
use Throwable;

class SlackExceptionAlert implements AlertContract
{
    public function __construct(private readonly Throwable $throwable)
    {
    }

    public function send(): void
    {
        SlackAlert::to(AlertWebhook::EXCEPTION)->blocks([
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
                    'text' => '*Type:* ' . get_class($this->throwable),
                ]
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => '*Message:* ' . $this->throwable->getMessage(),
                ]
            ],
            [
                'type' => 'section',
                'text' => [
                    'type' => 'mrkdwn',
                    'text' => '*File:* ' . $this->throwable->getFile(),
                ]
            ],
            [
                'type' => 'section',
                'fields' => [
                    [
                        'type' => 'mrkdwn',
                        'text' => '*Code:* ' . $this->throwable->getCode(),
                    ],
                    [
                        'type' => 'mrkdwn',
                        'text' => '*Line:* ' . $this->throwable->getLine(),
                    ],
                ]
            ],
        ]);
    }
}
