<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class GetByIdMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly GetMedicalServiceById $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        $medicalService = $this->service->handle(new MedicalServiceId($id));

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    'Found.',
                    $medicalService->toArray()
                )
            );
    }
}
