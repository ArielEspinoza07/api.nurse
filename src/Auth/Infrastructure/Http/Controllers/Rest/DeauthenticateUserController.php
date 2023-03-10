<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Deauthenticate\DeauthenticateUser;
use Src\Auth\Domain\AuthUserId;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class DeauthenticateUserController extends BaseController
{
    public function __construct(
        private readonly DeauthenticateUser $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $this->service->handle(
            new AuthUserId(auth()->id())
        );

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    Response::HTTP_OK,
                    'Logged out.'
                )
            );
    }
}
