<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Src\BackOffice\MedicalService\Application\Create\MedicalServiceCreator;
use Src\BackOffice\MedicalService\Domain\MedicalServiceName;
use Src\BackOffice\MedicalService\Infrastructure\Http\Request\CreateMedicalServiceRequest;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class CreateMedicalServiceController extends BaseController
{

    public function __construct(
        private readonly MedicalServiceCreator $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(CreateMedicalServiceRequest $request): JsonResponse
    {
        $medicalService = $this->service->handle(
            new MedicalServiceName($request->validated('name'))
        );

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    Response::HTTP_CREATED,
                    'Created.',
                    $medicalService->toArray()
                )
            );
    }
}
