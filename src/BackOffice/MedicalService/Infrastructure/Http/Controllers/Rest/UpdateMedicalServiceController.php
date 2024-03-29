<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\BackOffice\MedicalService\Application\Update\UpdateMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\BackOffice\MedicalService\Domain\MedicalServiceIsActive;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Infrastructure\Http\Request\UpdateMedicalServiceRequest;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class UpdateMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly UpdateMedicalService $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(int $id, UpdateMedicalServiceRequest $request): JsonResponse
    {
        $medicalService = $this->service->handle(
            MedicalServiceId::create($id),
            $request->has('name') ? MedicalServiceName::create($request->validated('name')) : null,
            $request->has('is_active') ? MedicalServiceIsActive::create($request->validated('is_active')) : null
        );

        return $this->response->send('Updated.', $medicalService->toArray());
    }
}
