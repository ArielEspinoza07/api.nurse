<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert;

use Src\shared\Domain\Notification\Slack\Alert\Contract\BaseAlertContract;
use Throwable;

class ExceptionAlert implements BaseAlertContract
{
    private function __construct(private readonly Throwable $throwable)
    {
    }

    public static function create(Throwable $throwable): self
    {
        return new static($throwable);
    }

    public function to(): string
    {
        return AlertWebhook::EXCEPTION;
    }

    public function message(): string
    {
        return $this->throwable->getMessage();
    }

    public function block(): array
    {
        return [
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
        ];
    }
}
