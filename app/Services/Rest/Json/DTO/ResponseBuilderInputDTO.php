<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\DTO;

use Symfony\Component\HttpFoundation\Response;

class ResponseBuilderInputDTO
{
    public function __construct(
        public readonly string $message,
        public readonly array|null $data = null,
        public readonly int $code = Response::HTTP_OK,
        public readonly bool $success = true,
    ) {
    }
}
