<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\BackOffice\MedicalService\Application\Create\CreateMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Infrastructure\Http\Request\CreateMedicalServiceRequest;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Src\shared\Infrastructure\Response\Rest\Json;
use Symfony\Component\HttpFoundation\Response;

class CreateMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly CreateMedicalService $service,
        private readonly Json $response
    ) {
    }

    public function __invoke(CreateMedicalServiceRequest $request): JsonResponse
    {
        $medicalService = $this->service->handle(
            new MedicalServiceName($request->validated('name'))
        );

        return $this->response->send('Created.', $medicalService->toArray(), Response::HTTP_CREATED);
    }
}
