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
}
