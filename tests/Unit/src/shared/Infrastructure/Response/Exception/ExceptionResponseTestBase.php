<?php

namespace Tests\Unit\src\shared\Infrastructure\Response\Exception;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ExceptionResponseTestBase extends TestCase
{

    protected function createException(): InvalidArgumentException
    {
        return new InvalidArgumentException('Invalid argument name', Response::HTTP_BAD_REQUEST);
    }
}
