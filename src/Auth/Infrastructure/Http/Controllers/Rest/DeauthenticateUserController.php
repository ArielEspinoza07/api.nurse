<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Deauthenticate\DeauthenticateUser;
use Src\Auth\Domain\AuthUserId;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class DeauthenticateUserController extends BaseController
{
    public function __construct(
        private readonly DeauthenticateUser $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(): JsonResponse
    {
        $this->service->handle(
            new AuthUserId(auth()->id())
        );

        return $this->response->send('Logged out.');
    }
}
