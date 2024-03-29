<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\BackOffice\MedicalService\Application\Delete\DeleteMedicalService;
use Src\BackOffice\MedicalService\Domain\MedicalServiceId;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class DeleteMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly DeleteMedicalService $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(int $id): JsonResponse
    {
        $this->service->handle(MedicalServiceId::create($id));

        return $this->response->send('Deleted.', null, Response::HTTP_NO_CONTENT);
    }
}
