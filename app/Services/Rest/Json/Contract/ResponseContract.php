<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Contract;

use App\Services\Rest\Json\DTO\ResponseInputDTO;
use Illuminate\Http\JsonResponse;

interface ResponseContract
{
    public function handle(ResponseInputDTO $inputDTO): JsonResponse;
}
