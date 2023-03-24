<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Src\shared\Domain\Notification\Slack\Alert\ExceptionAlert;
use Src\shared\Infrastructure\Notification\Slack\Alert\SlackNotificationAlert;
use Src\shared\Infrastructure\Response\Exception\Rest\JsonException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, Request $request) {
            if ($request->header('Content-Type') === 'application/json') {
                return (new JsonException())
                    ->send($e);
            }
        });
        $this->reportable(function (Throwable $e) {
            (new SlackNotificationAlert())->sendBlock(ExceptionAlert::create($e));
        });
    }
}
