<?php

declare(strict_types=1);

namespace Src\Auth\Infrastructure\Http\Controllers\Rest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\Auth\Application\Verify\VerifyUser;
use Src\Auth\Domain\AuthUserId;
use Src\Auth\Domain\Exception\InvalidOrExpiredUrlException;
use Src\shared\Domain\Response\Contract\RestResponseContract;
use Src\shared\Infrastructure\Http\Controllers\BaseController;

class VerifyUserController extends BaseController
{
    public function __construct(
        private readonly VerifyUser $service,
        private readonly RestResponseContract $response
    ) {
    }

    public function __invoke(Request $request, int $id): JsonResponse
    {
        if (!$request->hasValidSignature()) {
            throw new InvalidOrExpiredUrlException();
        }
        $this->service->handle(AuthUserId::create($id));

        return $this->response->send('Verified.');
    }
}
