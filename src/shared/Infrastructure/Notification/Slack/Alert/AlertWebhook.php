<?php

declare(strict_types=1);

namespace Src\shared\Infrastructure\Notification\Slack\Alert;

enum AlertWebhook: string
{
    public const EXCEPTION = 'exceptions';
}
