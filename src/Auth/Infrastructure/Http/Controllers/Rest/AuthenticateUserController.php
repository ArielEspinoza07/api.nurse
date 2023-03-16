<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Infrastructure\Http\Request\AuthenticateUserRequest;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateUserController extends BaseController
{
    public function __construct(
        private readonly AuthenticateUser $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(AuthenticateUserRequest $request): JsonResponse
    {
        $token = $this->service->handle(
            new AuthUserEmail($request->validated('email')),
            new AuthUserPassword($request->validated('password'))
        );

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    Response::HTTP_OK,
                    'Logged in.',
                    $token->toArray()
                )
            );
    }
}
