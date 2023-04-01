<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Infrastructure\Http\Request\AuthenticateUserRequest;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class AuthenticateUserController extends BaseController
{
    public function __construct(
        private readonly AuthenticateUser $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(AuthenticateUserRequest $request): JsonResponse
    {
        $response = $this->service->handle(
            AuthUserEmail::createNotVerified($request->validated('email')),
            AuthUserPassword::create($request->validated('password'))
        );

        return $this->response->send('Logged in.', $response->toArray());
    }
}
