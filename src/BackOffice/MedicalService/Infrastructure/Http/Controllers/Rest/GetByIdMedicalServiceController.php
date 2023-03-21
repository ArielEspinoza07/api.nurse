<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\BackOffice\MedicalService\Application\Find\GetMedicalServiceById;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Src\shared\Infrastructure\Response\Rest\Json;

class GetByIdMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly GetMedicalServiceById $service,
        private readonly Json $response
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        $medicalService = $this->service->handle(new MedicalServiceId($id));

        return $this->response->send('Found.', $medicalService->toArray());
    }
}
