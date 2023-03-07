<?php

declare(strict_types=1);

namespace App\Services\Rest\Json\Contract;

use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;

interface ResponseBuilderContract
{

    public function build(ResponseBuilderInputDTO $inputDTO): JsonResponse;
}
