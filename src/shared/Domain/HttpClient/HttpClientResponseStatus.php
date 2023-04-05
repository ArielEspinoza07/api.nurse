<?php

declare(strict_types=1);

namespace Src\shared\Domain\HttpClient;

use Src\shared\Domain\ValueObject\IntValueObject;

class HttpClientResponseStatus extends IntValueObject
{
    protected function __construct(protected int $value)
    {
        parent::__construct($this->value);
    }

    public static function create(int $value): HttpClientResponseStatus
    {
        return new static($value);
    }

    public function clientError(): bool
    {
        return $this->value >= 400 && $this->value < 500;
    }

    public function failed(): bool
    {
        return $this->serverError() || $this->clientError();
    }

    public function redirect(): bool
    {
        return $this->value >= 300 && $this->value < 400;
    }

    public function serverError(): bool
    {
        return $this->value >= 500;
    }

    public function successful(): bool
    {
        return $this->value >= 200 && $this->value < 300;
    }
}
