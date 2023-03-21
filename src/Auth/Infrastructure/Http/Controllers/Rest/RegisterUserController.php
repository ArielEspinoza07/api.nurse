<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Register\RegisterUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserName;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Infrastructure\Http\Request\RegisterUserRequest;
use Src\shared\Domain\Response\Contract\RestResponseContract;

class RegisterUserController
{
    public function __construct(
        private readonly RegisterUser $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(RegisterUserRequest $request): JsonResponse
    {
        $token = $this->service->handle(
            AuthUserName::create($request->validated('name')),
            AuthUserEmail::create($request->validated('email')),
            AuthUserPassword::create($request->validated('password'))
        );

        return $this->response->send('Registered.', $token->toArray());
    }
}
