<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BackOffice\MedicalService\Application\SearchAll\SearchMedicalService;
use Src\shared\Infrastructure\Criteria\CriteriaConverter;
use Src\shared\Infrastructure\Criteria\DTO\SearchByCriteriaInputDTO;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class SearchMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly SearchMedicalService $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $medicalServices = $this->service->handle(
            (new CriteriaConverter(
                SearchByCriteriaInputDTO::createFromRequest($request)
            ))->converter()
        );
        if (!empty($medicalServices['data'])) {
            $medicalServices = [
                'items' => $medicalServices['data'],
                'meta' => [
                    'page' => $medicalServices['current_page'],
                    'per_page' => $medicalServices['per_page'],
                    'page_count' => count($medicalServices['data']),
                    'total_count' => $medicalServices['total'],
                    'links' => $medicalServices['links'],
                ],
            ];
        }

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    Response::HTTP_OK,
                    'Retrieved all.',
                    $medicalServices
                )
            );
    }
}
