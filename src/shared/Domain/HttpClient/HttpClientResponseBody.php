<?php

declare(strict_types=1);

namespace Src\shared\Domain\HttpClient;

use Src\shared\Domain\ValueObject\StringValueObject;

class HttpClientResponseBody extends StringValueObject
{
    protected function __construct(protected string $value)
    {
        parent::__construct($this->value);
    }

    public static function create(string $value): HttpClientResponseBody
    {
        return new static($value);
    }

    public function object()
    {
        return json_decode($this->value, false);
    }

    public function toArray(): array
    {
        return json_decode($this->value, true);
    }
}
