<?php

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Find\GetAuthenticateUserById;
use Src\Auth\Domain\AuthUserId;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class GetAuthenticatedUserByIdController extends BaseController
{
    public function __construct(
        private readonly GetAuthenticateUserById $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $authenticatedUser = $this->service->handle(AuthUserId::create(auth()->id()));

        return $this->response->send('Authenticated user retrieved.', $authenticatedUser->toArray());
    }
}
