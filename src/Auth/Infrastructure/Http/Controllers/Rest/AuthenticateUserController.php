<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Authenticate\AuthenticateUser;
use Src\Auth\Domain\AuthUserEmail;
use Src\Auth\Domain\AuthUserPassword;
use Src\Auth\Infrastructure\Http\Request\AuthenticateUserRequest;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Src\shared\Infrastructure\Response\Rest\Json;

class AuthenticateUserController extends BaseController
{
    public function __construct(
        private readonly AuthenticateUser $service,
        private readonly Json $response
    ) {
    }

    public function __invoke(AuthenticateUserRequest $request): JsonResponse
    {
        $token = $this->service->handle(
            new AuthUserEmail($request->validated('email')),
            new AuthUserPassword($request->validated('password'))
        );

        return $this->response->send('Logged in.', $token->toArray());
    }
}
