<?php

declare(strict_types=1);

namespace Src\shared\Domain\Response;

class ResponseData
{
    private function __construct(
        private readonly ResponseMessage $message,
        private readonly ResponseSuccess $success,
        private readonly array|null $data = null
    ) {
    }

    public static function create(ResponseMessage $message, ResponseSuccess $success, array $data): self
    {
        return new static($message, $success, $data);
    }

    public static function createFromMessageAndSuccess(ResponseMessage $message, ResponseSuccess $success): self
    {
        return new static($message, $success);
    }

    public function message(): ResponseMessage
    {
        return $this->message;
    }

    public function success(): ResponseSuccess
    {
        return $this->success;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return [
            'success' => $this->success->value(),
            'message' => $this->message->value(),
            'data' => $this->data,
        ];
    }
}
