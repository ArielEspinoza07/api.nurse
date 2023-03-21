<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Src\Auth\Application\Deauthenticate\DeauthenticateUser;
use Src\Auth\Domain\AuthUserId;
use Src\shared\Infrastructure\Http\Controllers\BaseController;
use Src\shared\Infrastructure\Response\Rest\Json;

class DeauthenticateUserController extends BaseController
{
    public function __construct(
        private readonly DeauthenticateUser $service,
        private readonly Json $response
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
