<?php

declare(strict_types=1);

namespace Src\shared\Domain\Notification\Slack\Alert;

use Src\shared\Domain\Notification\Slack\Alert\Contract\MessageAlertContract;
use Throwable;

class ExceptionMessageAlert implements MessageAlertContract
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
}
