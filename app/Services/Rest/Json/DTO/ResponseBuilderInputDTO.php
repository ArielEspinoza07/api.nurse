<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\DTO;

class ResponseBuilderInputDTO
{
    public function __construct(
        public readonly int $code,
        public readonly string $message,
        public readonly array|null $data = null,
        public readonly bool $success = true,
    ) {
    }
}
