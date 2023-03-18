<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\DTO;

class ResponseInputDTO
{
    public function __construct(
        public readonly int $code,
        public readonly array $data
    ) {
    }

    public static function createFromValues(
        string $message,
        int $code,
        array|null $data = null,
        bool $success = true
    ): self {
        return new static(
            $code,
            [
                'success' => $success,
                'message' => $message,
                'data' => $data,
            ]
        );
    }
}
