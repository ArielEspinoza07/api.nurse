<?php

declare(strict_types=1);

namespace Src\BackOffice\MedicalService\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\BackOffice\MedicalService\Application\Count\CountMedicalService;
use Src\shared\Infrastructure\Criteria\CriteriaConverter;
use Src\shared\Infrastructure\Criteria\DTO\SearchByCriteriaInputDTO;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class CountMedicalServiceController extends BaseController
{
    public function __construct(
        private readonly CountMedicalService $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $medicalServices = $this->service->handle(
            (new CriteriaConverter(
                SearchByCriteriaInputDTO::createFromRequest($request)
            ))->convert()
        );

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    'Ok.',
                    [
                        'total' => $medicalServices,
                    ],
                    Response::HTTP_OK
                )
            );
    }
}
