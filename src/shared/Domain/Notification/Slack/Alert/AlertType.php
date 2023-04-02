<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert;

enum AlertType: string
{
    public const BLOCK = 'block';
    public const MESSAGE = 'message';

    public static function toArray(): array
    {
        return [
            self::BLOCK,
            self::MESSAGE,
        ];
    }
}
