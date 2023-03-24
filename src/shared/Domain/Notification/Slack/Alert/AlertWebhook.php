<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert;

enum AlertWebhook: string
{
    public const EXCEPTION = 'exceptions';
}
