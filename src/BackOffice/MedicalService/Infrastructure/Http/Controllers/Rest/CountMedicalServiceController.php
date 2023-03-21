<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BackOffice\MedicalService\Application\Count\CountMedicalService;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Criteria\RequestToCriteria;
use Src\shared\Infrastructure\Criteria\DTO\SearchByCriteriaInputDTO;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class CountMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly CountMedicalService $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $countMedicalServices = $this->service->handle(
            RequestToCriteria::create(
                $request->get('filters', ''),
                $request->get('order'),
                $request->get('page'),
                $request->get('limit'),
            )->convert()
        );

        return $this->response->send('Ok.', $countMedicalServices);
    }
}
