<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use App\Services\Rest\Json\Contract\ResponseBuilderContract;
use App\Services\Rest\Json\DTO\ResponseBuilderInputDTO;
use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Register\RegisterUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Infrastructure\Http\Request\RegisterUserRequest;
use Symfony\Component\HttpFoundation\Response;

class RegisterUserController
{
    public function __construct(
        private readonly RegisterUser $service,
        private readonly ResponseBuilderContract $response
    ) {
    }

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $token = $this->service->handle(
            new AuthUserName($request->validated('name')),
            new AuthUserEmail($request->validated('email')),
            new AuthUserPassword($request->validated('password'))
        );

        return $this->response
            ->build(
                new ResponseBuilderInputDTO(
                    Response::HTTP_OK,
                    'Registered.',
                    $token->toArray()
                )
            );
    }
}
