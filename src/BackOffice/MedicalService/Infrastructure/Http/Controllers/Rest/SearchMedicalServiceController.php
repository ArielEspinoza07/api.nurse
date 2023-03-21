<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BackOffice\MedicalService\Application\Search\SearchMedicalService;
use Src\shared\Infrastructure\Criteria\CriteriaConverter;
use Src\shared\Infrastructure\Criteria\DTO\SearchByCriteriaInputDTO;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Src\shared\Infrastructure\Response\Rest\Json;

class SearchMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly SearchMedicalService $service,
        private readonly Json $response
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $medicalServices = $this->service->handle(
            (new CriteriaConverter(
                SearchByCriteriaInputDTO::createFromRequest($request)
            ))->convert()
        );

        return $this->response->send('Retrieved all.', $medicalServices);
    }
}
