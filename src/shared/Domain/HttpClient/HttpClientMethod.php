<?php

declare(strict_types=1);

namespace Src\shared\Domain\HttpClient;

enum HttpClientMethod: string
{
    public const GET = 'GET';
    public const DELETE = 'DELETE';
    public const PATCH = 'PATCH';
    public const POST = 'POST';
    public const PUT = 'PUT';
}
